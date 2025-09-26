<?php

namespace App\Services\Contracts;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use Illuminate\Http\UploadedFile;

interface StudentUpdaterServiceInterface
{
    public function execute(string $id, StudentDTO $data, ?UploadedFile $image = null): AssignStudent;
}
