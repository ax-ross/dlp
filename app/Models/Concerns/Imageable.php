<?php

namespace App\Models\Concerns;

use App\Models\Image;

trait Imageable
{
    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
