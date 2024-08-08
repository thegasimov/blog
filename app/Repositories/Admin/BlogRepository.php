<?php

namespace App\Repositories\Admin;

use App\Http\Services\ImageService;
use App\Models\Blog;
use App\Models\Blog_Langs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogRepository
{
    protected $imageService;

    /**
     * BlogRepository constructor.
     *
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Get all blogs with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Blog::with(['contentsAZ', 'contentsEN', 'contentsRU', 'category'])
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);
    }

    /**
     * Store a new blog and its translations.
     *
     * @param Request $request
     * @return bool
     */
    public function store(Request $request): bool
    {
        $blog = Blog::create($this->blogAttributes($request));
        $this->storeOrUpdateTranslations($request, $blog->id);

        return true;
    }

    /**
     * Update an existing blog and its translations.
     *
     * @param Request $request
     * @param int $blogId
     * @return bool
     */
    public function update(Request $request, int $blogId): bool
    {
        $blog = Blog::findOrFail($blogId);
        $blog->update($this->blogAttributes($request));
        $this->storeOrUpdateTranslations($request, $blogId);

        return true;
    }

    /**
     * Delete a blog by its ID.
     *
     * @param int $blogId
     * @return bool
     */
    public function delete(int $blogId): bool
    {
        $blog = Blog::findOrFail($blogId);

        // Delete featured image if exists
        $this->deleteImage($blog->featured_image);

        // Delete images referenced in blog languages
        $this->deleteBlogLangImages($blogId);

        // Delete blog languages
        Blog_Langs::where('blog_id', $blogId)->delete();

        // Delete blog
        return $blog->delete();
    }

    /**
     * Find a blog by its ID.
     *
     * @param int $blogId
     * @return Blog|null
     */
    public function find(int $blogId): ?Blog
    {
        return Blog::with(['contentsAZ', 'contentsEN', 'contentsRU', 'category'])->find($blogId);
    }

    /**
     * Get attributes for the blog model.
     *
     * @param Request $request
     * @return array
     */
    protected function blogAttributes(Request $request): array
    {
        $attributes = [
            'status' => $request->status ?? 'draft',
            'author_id' => $request->author_id ?? auth()->user()->id,
            'category_id' => (int)$request->category,
            'published_at' => $request->published_at ?? now(),
        ];

        // Check if an image file is uploaded
        if ($request->hasFile('image')) {
            $attributes['featured_image'] = $this->imageService->featuredImageUpload($request);
        }

        return $attributes;
    }

    /**
     * Get attributes for the blog language model.
     *
     * @param Request $request
     * @param int $id
     * @param string $lang
     * @return array
     */
    protected function blogLangAttributes(Request $request, int $id, string $lang): array
    {
        return [
            'slug' => Str::slug($request->input('name_'.$lang)),
            'blog_id' => $id,
            'lang' => $lang,
            'name' => $request->input('name_'.$lang),
            'content' => $request->input('content_'.$lang),
            'title' => $request->input('title_'.$lang),
            'description' => $request->input('description_'.$lang),
        ];
    }

    /**
     * Check if the given attributes have content.
     *
     * @param array $attributes
     * @return bool
     */
    protected function hasContent(array $attributes): bool
    {
        return !empty($attributes['name']) ||
            !empty($attributes['content']) ||
            !empty($attributes['title']) ||
            !empty($attributes['description']) ||
            !empty($attributes['slug']);
    }

    /**
     * Store or update blog translations.
     *
     * @param Request $request
     * @param int $blogId
     * @return void
     */
    protected function storeOrUpdateTranslations(Request $request, int $blogId): void
    {
        $langs = config('app.locales');

        foreach ($langs as $lang) {
            $attributes = $this->blogLangAttributes($request, $blogId, $lang);

            if ($this->hasContent($attributes)) {
                Blog_Langs::updateOrCreate(
                    ['blog_id' => $blogId, 'lang' => $lang],
                    $attributes
                );
            }
        }
    }

    /**
     * Delete image from storage.
     *
     * @param string|null $imagePath
     * @return void
     */
    protected function deleteImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        } else {
            Log::info("Image not found: " . $imagePath);
        }
    }

    /**
     * Delete images referenced in blog languages.
     *
     * @param int $blogId
     * @return void
     */
    protected function deleteBlogLangImages(int $blogId): void
    {
        $blogLangs = Blog_Langs::where('blog_id', $blogId)->get();
        $baseUrl = rtrim(Config::get('app.url'), '/');
        $storageUrl = rtrim($baseUrl . '/storage', '/');

        foreach ($blogLangs as $blogLang) {
            $images = $this->imageService->getAllImages($blogLang->content);

            foreach ($images as $image) {
                $cleanedImage = trim($image);

                if (strpos($cleanedImage, $storageUrl) === 0) {
                    $relativePath = substr($cleanedImage, strlen($storageUrl));
                    $fullPath = ltrim($relativePath, '/');

                    $this->deleteImage($fullPath);
                } else {
                    Log::info("Storage URL: " . $storageUrl);
                }
            }
        }
    }
}
