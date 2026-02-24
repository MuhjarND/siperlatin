<?php

namespace App\Http\Controllers;

class StorageController extends Controller
{
    public function foto($filename)
    {
        $safeName = basename($filename);
        $path = storage_path('foto/'.$safeName);

        if (!is_file($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function file($filename)
    {
        $safeName = basename($filename);
        $path = storage_path('files/'.$safeName);

        if (!is_file($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
