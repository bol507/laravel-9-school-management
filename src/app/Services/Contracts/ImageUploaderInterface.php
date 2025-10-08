<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * Defines the contract for uploading and managing image files.
 * Implementations should handle storage, naming, and deletion of images
 * in a consistent and secure manner (e.g., using local storage, S3, etc.).
 */
interface ImageUploaderInterface
{
    /**
     * Uploads the given file to the configured storage and returns the stored file path or URL.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded file to store.
     * @return string The relative path or public URL of the stored image.
     * @throws \RuntimeException If the upload fails (e.g., due to permissions, invalid file, etc.).
     */
    public function upload(UploadedFile $file): string;

    /**
     * Deletes the image file at the given path or URL from storage.
     * If the path is null or empty, the method should do nothing.
     *
     * @param string|null $pathOrUrl The stored path or public URL of the image to delete.
     * @return void
     */
    public function delete(?string $pathOrUrl): void;
}
