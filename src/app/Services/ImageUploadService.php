<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\Contracts\ImageUploaderInterface;

final class ImageUploadService implements ImageUploaderInterface
{
    private const DISK = 'public';

    public function upload(UploadedFile $file): string
    {
        $path = $file->store('employees', self::DISK);
        if ($path === false) {
            throw new \RuntimeException('Failed to store image');
        }
        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path === null) { return; }
        Storage::disk(self::DISK)->delete($path);
    }
}