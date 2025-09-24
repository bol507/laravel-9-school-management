<?php
namespace App\Services\Contracts;

interface ImageBbUploaderInterface
{
    /**
     *
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     * @throws \RuntimeException
     */
    public function upload($file): string;

    /**
     *
     *
     *
     * @param string|null $pathOrUrl
     */
    public function delete(?string $pathOrUrl): void;
}
