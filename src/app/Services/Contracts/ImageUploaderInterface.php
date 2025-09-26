<?php
namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageUploaderInterface
{
    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     * @throws \RuntimeException
     */
    public function upload(UploadedFile $file): string;

    /**
     * @param string|null $path
     */
    public function delete(?string $pathOrUrl): void;
}
