<?php

namespace Modules\Media\Traits;

use Intervention\Image\Facades\Image;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Config;
use Plank\Mediable\Facades\MediaUploader;

trait MediaHandler
{
    /**
     * @param $file
     * @param User|null $user
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ConfigurationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileExistsException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotFoundException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileSizeException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ForbiddenException
     */
    public function uploadAvatar($file, User $user = null): void
    {
        $user = $user ?? auth()->user();

        $media = MediaUploader::fromSource($file)
            ->toDisk(Config::get('media.drive'))
            ->toDirectory($user->id)
            ->useHashForFilename()
            ->upload();

        Image::make($media->getAbsolutePath())->fit(160, 160)->save();

        $user->syncMedia($media, 'avatar');

        // $file->delete();
    }
}
