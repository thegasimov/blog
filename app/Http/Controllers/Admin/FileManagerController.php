<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function imageUpload(Request $request)
    {

        $response = $this->imageService->upload($request);

        return $response;

    }
    public function deleteImage(Request $request){
        $url = $request->input('url');

        // Extract the filename from URL
        $filename = basename($url);

        // Delete the image from storage
        if (Storage::exists('public/images/' . $filename)) {
            Storage::delete('public/images/' . $filename);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
