<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('storage', $value),
        );
    }


    public static function findImageByAbsolutePath($absolutePath): Image|null
    {
        $path = parse_url($absolutePath, PHP_URL_PATH);
        if (str_starts_with($path, '/storage/')) {
            $path = substr($path, strlen('/storage/'));
        }
        $path = urldecode($path);
        return Image::where('path', $path)->first();
    }
}
