<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\Employee\EmployeeRegistrationController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;
use App\Http\Controllers\Backend\Setup\DesignationController;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\FeeAmountController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\SchoolSubjectController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Student\ExamFeeController;
use App\Http\Controllers\Backend\Student\MonthlyFeeController;
use App\Http\Controllers\Backend\Student\RegistrationFeeController;
use App\Http\Controllers\Backend\Student\StudentRegistrationController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Auth\Events\Verified;

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
    //student class
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
    //school subject
    Route::get('/school/subject/view', [SchoolSubjectController::class, 'ViewSchoolSubject'])->name('school.subject.view');
    Route::get('/school/subject/add', [SchoolSubjectController::class,'AddSchoolSubject'])->name('school.subject.add');
    Route::post('/school/subject/store', [SchoolSubjectController::class,'StoreSchoolSubject'])->name('school.subject.store');
    Route::get('/school/subject/edit/{id}', [SchoolSubjectController::class, 'EditSchoolSubject'])->name('school.subject.edit');
    Route::put('/school/subject/update/{id}', [SchoolSubjectController::class,'UpdateSchoolSubject'])->name('school.subject.update');
    Route::delete('/school/subject/destroy/{id}', [SchoolSubjectController::class, 'DeleteSchoolSubject'] )->name('school.subject.destroy');
    //assign subject
    Route::get('/assign/subject/view', [AssignSubjectController::class , 'ViewAssignSubject'])->name('assign.subject.view');
    Route::get('/assign/subject/add', [AssignSubjectController::class, 'AddAssignSubject'])->name('assign.subject.add');
    Route::post('/assign/subject/store', [AssignSubjectController::class , 'StoreAssignSubject'])->name('assign.subject.store');
    Route::get('/assign/subject/edit/{id}', [AssignSubjectController::class , 'EditAssignSubject'])->name('assign.subject.edit');
    Route::put('/assign/subject/update/{id}', [AssignSubjectController::class , 'UpdateAssignSubject'])->name('assign.subject.update');
    Route::get('/assign/subject/details/{id}', [AssignSubjectController::class , 'DetailsAssignSubject'])->name('assign.subject.details');
    //Designation
    Route::get('/designation/view', [DesignationController::class, 'ViewDesignation'])->name('designation.view');
    Route::get('/designation/add', [DesignationController::class,'AddDesignation'])->name('designation.add');
    Route::post('/designation/store', [DesignationController::class,'StoreDesignation'])->name('designation.store');
    Route::get('/designation/edit/{id}', [DesignationController::class, 'EditDesignation'])->name('designation.edit');
    Route::put('/designation/update/{id}', [DesignationController::class,'UpdateDesignation'])->name('designation.update');
    Route::delete('/designation/destroy/{id}', [DesignationController::class, 'DeleteDesignation'] )->name('designation.destroy');

});

Route::prefix('students')->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
    //student registration
    Route::get('/registration', [StudentRegistrationController::class , 'index'])->name('student.registration.view');
    Route::get('/registration/add', [StudentRegistrationController::class, 'create'])->name('student.registration.add');
    Route::post('/registration/store', [StudentRegistrationController::class, 'store'])->name('student.registration.store');
    Route::get('/registration/edit/{id}', [StudentRegistrationController::class , 'edit'])->name('student.registration.edit');
    Route::put('/registration/update/{id}', [StudentRegistrationController::class , 'update'])->name('student.registration.update');
    Route::get('/registration/details/{id}', [StudentRegistrationController::class , 'show'])->name('student.registration.details');
    //student promotion
    Route::get('/promotion/edit/{id}', [StudentRegistrationController::class , 'EditStudentPromotion'])->name('student.promotion.edit');
    Route::put('/promotion/update/{id}', [StudentRegistrationController::class , 'UpdateStudentPromotion'])->name('student.promotion.update');
    //registration fee
    Route::get('/registration/fee/view', [RegistrationFeeController::class, 'ViewRegistrationFee'])->name('registration.fee.view');
    Route::get('/registration/fee/payslip',[RegistrationFeeController::class, 'PayslipRegistrationFee'])->name('registration.fee.payslip');
    //Montly fee
    Route::get('/monthly/fee/view',[MonthlyFeeController::class, 'ViewMonthlyFee'])->name('monthly.fee.view');
    Route::get('/monthly/fee/payslip',[MonthlyFeeController::class, 'PayslipMonthlyFee'])->name('monthly.fee.payslip');
    //Exam fee
    Route::get('/exam/fee/view',[ExamFeeController::class, 'ViewExamFee'])->name('exam.fee.view');
    Route::get('/exam/fee/payslip',[ExamFeeController::class, 'PayslipExamFee'])->name('exam.fee.payslip');

});

Route::prefix('employees')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])
    ->group( function (){
        //employee registration
        Route::get('/registration',[EmployeeRegistrationController::class, 'index'])->name('employee.registration.view');
        Route::get('/registration/add', [EmployeeRegistrationController::class, 'create'])->name('employee.registration.add');
        Route::post('/registration/store', [EmployeeRegistrationController::class, 'store'])->name('employee.registration.store');
        Route::get('/registration/edit/{id}', [EmployeeRegistrationController::class , 'edit'])->name('employee.registration.edit');
        Route::put('/registration/update/{id}', [EmployeeRegistrationController::class , 'update'])->name('employee.registration.update');
    });
