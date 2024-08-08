<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ImageService
{
    protected $folderPath;
    protected $fileName;

    /**
     * Handle file upload and return response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        // Get parameters
        $folder = $request->input('folder', 'media');
        $lang = $request->input('lang', 'en');

        // Sanitize parameters
        $folder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $folder);
        $lang = preg_replace('/[^a-zA-Z0-9_\-]/', '', $lang);

        // Create folder path
        $this->folderPath = "{$folder}/{$lang}";

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $originName = $file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Store the file in the dynamic folder
            $filePath = $file->storeAs($this->folderPath, $fileName, 'public');

            $url = asset('storage/' . $filePath);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }

        return response()->json(['uploaded' => 0, 'error' => 'No file uploaded'], 400);
    }

    public function featuredImageUpload(Request $request)
    {
        if ($request->file('image')->isValid()) {
            // Get the original file name without extension
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);

            // Slugify the original name
            $slugName = Str::slug($originalName);

            // Get the file extension
            $extension = $request->file('image')->getClientOriginalExtension();

            // Generate a unique file name
            $fileName = $slugName . '-' . substr(Uuid::uuid4()->toString(), 0, 5) . '.' . $extension;

            // Store the file temporarily
            $temporaryFile = $request->file('image')->store('temp');

            // Move the file to the public storage with the new name
            $path = Storage::disk('public')->putFileAs('blog/featured_images', new File(storage_path('app/' . $temporaryFile)), $fileName);

            // Delete the temporary file
            Storage::delete($temporaryFile);

            // Return the path of the stored file
            return $path;
        }

        return false;
    }


    /**
     * İçerikteki tüm resimlerin yollarını döndürür.
     *
     * @param string $content
     * @return array
     */
    public function getAllImages(string $content): array
    {
        $images = [];

        $dom = new \DOMDocument();
        @$dom->loadHTML($content);

        $tags = $dom->getElementsByTagName('img');

        foreach ($tags as $tag) {
            $src = $tag->getAttribute('src');
            if ($src) {
                $images[] = $src;
            }
        }

        return $images;
    }
}
