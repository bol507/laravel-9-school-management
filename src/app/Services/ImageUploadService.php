<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageUploadService
{
    public function uploadImage($image)
    {
        if (!$image->isValid()) {
            throw new \Exception('Uploaded file is not valid.');
        }

        $apiKey = env('IMGBB_API_KEY');
        if (!$apiKey) {
            Log::debug('An error in api key: ' . $apiKey);
            throw new \Exception('Error in api key');
        }

        $response = Http::attach(
            'image',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post('https://api.imgbb.com/1/upload?key=' . $apiKey);

        if ($response->successful() && ($url = data_get($response->json(), 'data.url'))) {
            return $url;
        } else {
            Log::debug('imgBB multipart error', $response->json());
            return null;
        }
    }
}