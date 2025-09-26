<?php

namespace App\Services\Contracts;

use App\DTO\StudentDTO;
use App\Models\AssignStudent;
use Illuminate\Http\UploadedFile;

interface StudentCreatorServiceInterface {

    public function execute(StudentDTO $data, ?UploadedFile $image = null): AssignStudent;
}
