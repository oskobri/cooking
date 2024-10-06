<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadImageFromUrl
{
    public function __invoke(string $storagePath, string $fileName, ?string $url): ?string
    {
        if(!$url) {
            return null;
        }

        $response = Http::get($url);

        if($response->getStatusCode() !== 200) {
            return null;
        }

        $extension = pathinfo($url, PATHINFO_EXTENSION);

        $fullFileName = "$fileName.$extension";

        Storage::disk('public')->put($storagePath . $fullFileName, $response->getBody()->getContents());

        return $fullFileName;
    }
}
