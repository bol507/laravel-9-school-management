<?php

namespace App\Services\Contracts;

use App\DTO\EmployeeDTO;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface EmployeeCreatorServiceInterface {

    public function execute(EmployeeDTO $data, ?UploadedFile $image = null): User;

}
