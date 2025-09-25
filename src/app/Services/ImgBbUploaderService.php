<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Contracts\ImageUploaderInterface;

final class ImgBbUploaderService implements ImageUploaderInterface
{
    private const ENDPOINT = 'https://api.imgbb.com/1/upload';

    public function upload($file): string
    {
        if (! $file instanceof UploadedFile || ! $file->isValid()) {
            throw new \RuntimeException('Uploaded file is not valid.');
        }

        $apiKey = config('services.imgbb.key');
        if (empty($apiKey)) {
            Log::error('ImgBB API key not configured');
            throw new \RuntimeException('Image service misconfigured.');
        }

        $response = Http::timeout(15)
            ->attach(
                'image',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post(self::ENDPOINT, [
                'key' => $apiKey,
                'expiration' => config('services.imgbb.expiration', 0),
            ]);

        if ($response->successful() && ($url = data_get($response->json(), 'data.url'))) {
            return $url;
        }

        Log::error('ImgBB upload error', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        throw new \RuntimeException('Image upload failed.');
    }

    public function delete(?string $pathOrUrl): void
    {
        // ImgBB does not support deleting images via API without the delete URL.
        // If you have stored the delete URL when uploading, you can implement deletion here.
        // For now, we will log that deletion is not supported.
        if ($pathOrUrl) {
            Log::info('ImgBB deletion not supported via API. URL: ' . $pathOrUrl);
        }
    }
}
