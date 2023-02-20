<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(StoreImageRequest $request)
    {
        $image = Image::create(['path' => $request->file('image')->store('/images', 'public')]);
        return response()->json([
            'url' => $image->path
        ]);
    }
}
