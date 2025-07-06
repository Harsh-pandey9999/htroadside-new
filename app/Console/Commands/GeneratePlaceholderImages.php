<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;

class GeneratePlaceholderImages extends Command
{
    protected $signature = 'generate:placeholder-images';
    protected $description = 'Generate placeholder images for the website';

    public function handle()
    {
        // Create logo
        $logo = Image::canvas(200, 50, '#ffffff');
        $logo->text('HT Roadside', 100, 25, function($font) {
            $font->file(public_path('fonts/Roboto-Bold.ttf'));
            $font->size(24);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });
        $logo->save(public_path('storage/website/logo/logo-white.png'));

        // Create favicon
        $favicon = Image::canvas(32, 32, '#ffffff');
        $favicon->circle(16, 16, 16, function ($draw) {
            $draw->background('#000000');
        });
        $favicon->text('HT', 16, 16, function($font) {
            $font->file(public_path('fonts/Roboto-Bold.ttf'));
            $font->size(16);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });
        $favicon->save(public_path('storage/website/favicon/favicon.ico'));

        $this->info('Placeholder images generated successfully!');
    }
} 