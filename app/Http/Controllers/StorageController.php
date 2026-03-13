<?php

namespace App\Http\Controllers;

class StorageController extends Controller
{
    private function resolvePath($directory, $filename)
    {
        $safeName = basename($filename);
        $candidates = [
            storage_path($directory.'/'.$safeName),
            storage_path('app/public/'.$directory.'/'.$safeName),
            public_path('storage/'.$directory.'/'.$safeName),
        ];

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    private function emptyImagePath()
    {
        $candidates = [
            public_path('images/empty.png'),
            public_path('public/images/empty.png'),
        ];

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    public function foto($filename)
    {
        $path = $this->resolvePath('foto', $filename);

        if ($path) {
            return response()->file($path);
        }

        $fallback = $this->emptyImagePath();

        if ($fallback) {
            return response()->file($fallback);
        }

        abort(404);
    }

    public function file($filename)
    {
        $path = $this->resolvePath('files', $filename);

        if (!$path) {
            abort(404);
        }

        return response()->file($path);
    }
}
