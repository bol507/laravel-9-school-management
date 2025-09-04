<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\FeeAmountController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\UserController;
use App\Models\FeeCategory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/admin/logout', [AdminController::class , 'Logout'])->name('admin.logout');

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class , 'UserView'])->name('user.view');
    Route::get('/add', [UserController::class , 'UserAdd'])->name('user.add');
    Route::post('/store', [UserController::class , 'UserStore'])->name('user.store');
    Route::get('/password/edit', [UserController::class , 'passwordView'])->name('user.password');
    Route::put('/password/update', [UserController::class , 'passwordUpdate'])->name('user.password.update');
    Route::get('/edit/{id}', [UserController::class , 'UserEdit'])->name('user.edit');

    Route::put('/update/{id}', [UserController::class , 'UserUpdate'])->name('user.update');
    Route::delete('/destroy/{id}', [UserController::class , 'UserDelete'])->name('user.destroy');
});


Route::prefix('profile')->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
    Route::get('/', [ProfileController::class , 'show'])->name('profile.view');
    Route::get('/edit', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::put('/update/{id}', [ProfileController::class , 'update'])->name('profile.update');
});

Route::prefix('setups')->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
    //class
    Route::get('/student/class/view', [StudentClassController::class , 'ViewStudentClass'])->name('student.class.view');
    Route::get('/student/class/add', [StudentClassController::class, 'AddStudentClass'])->name('student.class.add');
    Route::post('/student/class/store', [StudentClassController::class, 'StoreStudentClass'])->name('student.class.store');
    Route::get('/student/class/edit/{id}', [StudentClassController::class , 'EditStudentClass'])->name('student.class.edit');
    Route::put('/student/class/update/{id}', [StudentClassController::class , 'UpdateStudentClass'])->name('student.class.update');
    Route::delete('/student/class/destroy/{id}', [StudentClassController::class , 'DeleteStudentClass'])->name('student.class.destroy');
    //year
    Route::get('/student/year/view', [StudentYearController::class , 'ViewStudentYear'])->name('student.year.view');
    Route::get('/student/year/add', [StudentYearController::class , 'AddStudentYear'])->name('student.year.add');
    Route::post('/student/year/store', [StudentYearController::class , 'StoreStudentYear'])->name('student.year.store');
    Route::get('/student/year/edit/{id}', [StudentYearController::class , 'EditStudentYear'])->name('student.year.edit');
    Route::put('/student/year/update/{id}', [StudentYearController::class , 'UpdateStudentYear'])->name('student.year.update');
    Route::delete('/student/year/destroy/{id}', [StudentYearController::class , 'DeleteStudentYear'])->name('student.year.destroy');
    //group
    Route::get('/student/group/view', [StudentGroupController::class , 'ViewStudentGroup'])->name('student.group.view');
    Route::get('/student/group/add', [StudentGroupController::class , 'AddStudentGroup'])->name('student.group.add');
    Route::post('/student/group/store', [StudentGroupController::class , 'StoreStudentGroup'])->name('student.group.store');
    Route::get('/student/group/edit/{id}', [StudentGroupController::class , 'EditStudentGroup'])->name('student.group.edit');
    Route::put('/student/group/update/{id}', [StudentGroupController::class , 'UpdateStudentGroup'])->name('student.group.update');
    Route::delete('/student/group/destroy/{id}', [StudentGroupController::class , 'DeleteStudentGroup'])->name('student.group.destroy');
    //Shift
    Route::get('/student/shift/view', [StudentShiftController::class , 'ViewStudentShift'])->name('student.shift.view');
    Route::get('/student/shift/add', [StudentShiftController::class , 'AddStudentShift'])->name('student.shift.add');
    Route::post('/student/shift/store', [StudentShiftController::class , 'StoreStudentShift'])->name('student.shift.store');
    Route::get('/student/shift/edit/{id}', [StudentShiftController::class , 'EditStudentShift'])->name('student.shift.edit');
    Route::put('/student/shift/update/{id}', [StudentShiftController::class , 'UpdateStudentShift'])->name('student.shift.update');
    Route::delete('/student/shift/destroy/{id}', [StudentShiftController::class , 'DeleteStudentShift'])->name('student.shift.destroy');
    //Fee Category
    Route::get('/fee/category/view', [FeeCategoryController::class , 'ViewFeeCategory'])->name('fee.category.view');
    Route::get('/fee/category/add', [FeeCategoryController::class, 'AddFeeCategory'])->name('fee.category.add');
    Route::post('/fee/categry/store', [FeeCategoryController::class , 'StoreFeeCategory'])->name('fee.category.store');
    Route::get('/fee/category/edit/{id}', [FeeCategoryController::class , 'EditFeeCategory'])->name('fee.category.edit');
    Route::put('/fee/category/update/{id}', [FeeCategoryController::class , 'UpdateFeeCategory'])->name('fee.category.update');
    Route::delete('/fee/category/destroy/{id}', [FeeCategoryController::class , 'DeleteFeeCategory'])->name('fee.category.destroy');
    //Fee Amount
    Route::get('/fee/amount/view', [FeeAmountController::class , 'ViewFeeAmount'])->name('fee.amount.view');
    Route::get('/fee/amount/add', [FeeAmountController::class, 'AddFeeAmount'])->name('fee.amount.add');
    Route::post('/fee/amount/store', [FeeAmountController::class , 'StoreFeeAmount'])->name('fee.amount.store');
    Route::get('/fee/amount/edit/{id}', [FeeAmountController::class , 'EditFeeAmount'])->name('fee.amount.edit');
    Route::put('/fee/amount/update/{id}', [FeeAmountController::class , 'UpdateFeeAmount'])->name('fee.amount.update');
    Route::get('/fee/amount/details/{id}', [FeeAmountController::class , 'DetailsFeeAmount'])->name('fee.amount.details');
    //Exam type
    Route::get('/exam/type/view', [ExamTypeController::class, 'ViewExamType'])->name('exam.type.view');
    Route::get('/exam/type/add', [ExamTypeController::class,'AddExamType'])->name('exam.type.add');
    Route::post('/exam/type/store', [ExamTypeController::class,'StoreExamType'])->name('exam.type.store');
    Route::get('/exam/type/edit/{id}', [ExamTypeController::class, 'EditExamType'])->name('exam.type.edit');
    Route::put('/exam/type/update/{id}', [ExamTypeController::class,'UpdateExamType'])->name('exam.type.update');
    Route::delete('/exam/type/destroy/{id}', [ExamTypeController::class, 'DeleteExamType'] )->name('exam.type.destroy');
});