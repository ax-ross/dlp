<?php

namespace App\Models\Concerns;

use App\Models\Image;

trait Imageable
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
