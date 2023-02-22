<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteUnusedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:delete-unused';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all images from images table which have empty imageable relation';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Storage::disk('public')->delete(Image::whereNull('imageable_id')->pluck('path')->all());
        Image::whereNull('imageable_id')->delete();
    }
}
