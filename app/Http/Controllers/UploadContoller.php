<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function store($folder, $file, $model, $field = '', $id = '', $fileName = '')
    {
        $size = ['original', 'xsmall', 'small', 'large'];
        $dimesions = [[], [80, 50], [150, 93], [550, 340]];

        $base64_image = $file['data'];
        list($type, $file_data) = explode(';', $base64_image);
        list(, $extension) = explode('/', $type);
        list(, $file_data) = explode(',', $file_data);

        $uuid =  Str::uuid();

        foreach ($size as $index => $item) {
            $extension = $file['extension'];
            $item = $item . '/';
            $name = $id ? $item . $folder . '/' . $fileName . $id . '.' . $extension : $item . $folder . '/' . $fileName . $uuid . '.' . $extension;

            if ($index == 0) {
                $model->update([$field => $name]);
            }

            if ($index == 0 || $extension != 'pdf') {
                Storage::disk('public')->put($name, base64_decode($file_data));
            }

            if ($index != 0 && $extension != 'pdf') {
                $this->createThumbnail(storage_path('app/public/' . $name), $dimesions[$index][0], $dimesions[$index][1]);
            }
        }
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
