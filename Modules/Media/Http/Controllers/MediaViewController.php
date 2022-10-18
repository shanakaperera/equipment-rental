<?php

namespace Modules\Media\Http\Controllers;

use Plank\Mediable\Media;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class MediaViewController extends Controller
{
    public function displayImage(Media $media)
    {
        return Storage::disk(Config::get('media.drive'))->download($media->getDiskPath());
    }
}
