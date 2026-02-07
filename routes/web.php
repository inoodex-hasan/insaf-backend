<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{CountryController, CourseController, CourseIntakeController, DashboardController, PaymentController, RoleController as LocalRoleController, SettingController, StudentController, UniversityController};
use App\Http\Controllers\Admin\Marketing\LeadController;


Route::get('/', function () {
    return redirect()->route('tyro-login.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('tyro-dashboard.index');

Route::prefix('dashboard/settings')->name('admin.settings.')->middleware('can:manage-settings')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('/update', [SettingController::class, 'update'])->name('update');
});

// Country Management
Route::prefix('dashboard/countries')->name('admin.countries.')->middleware('can:edit-data')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/create', [CountryController::class, 'create'])->name('create');
    Route::post('/', [CountryController::class, 'store'])->name('store');
    Route::get('{country}/edit', [CountryController::class, 'edit'])->name('edit');
    Route::put('{country}', [CountryController::class, 'update'])->name('update');
    Route::delete('{country}', [CountryController::class, 'destroy'])->name('destroy');
});

// University Management
Route::prefix('dashboard/universities')->name('admin.universities.')->middleware('can:edit-data')->group(function () {
    Route::get('/', [UniversityController::class, 'index'])->name('index');
    Route::get('/create', [UniversityController::class, 'create'])->name('create');
    Route::post('/', [UniversityController::class, 'store'])->name('store');
    Route::get('{university}/edit', [UniversityController::class, 'edit'])->name('edit');
    Route::put('{university}', [UniversityController::class, 'update'])->name('update');
    Route::delete('{university}', [UniversityController::class, 'destroy'])->name('destroy');
});

// Course Management
Route::prefix('dashboard/courses')->name('admin.courses.')->middleware('can:edit-data')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
    Route::post('/', [CourseController::class, 'store'])->name('store');
    Route::get('{course}/edit', [CourseController::class, 'edit'])->name('edit');
    Route::put('{course}', [CourseController::class, 'update'])->name('update');
    Route::delete('{course}', [CourseController::class, 'destroy'])->name('destroy');
});

// CourseIntake Management
Route::prefix('dashboard/course-intakes')->name('admin.course-intakes.')->middleware('can:edit-data')->group(function () {
    Route::get('/', [CourseIntakeController::class, 'index'])->name('index');
    Route::get('/create', [CourseIntakeController::class, 'create'])->name('create');
    Route::post('/', [CourseIntakeController::class, 'store'])->name('store');
    Route::get('{courseIntake}/edit', [CourseIntakeController::class, 'edit'])->name('edit');
    Route::put('{courseIntake}', [CourseIntakeController::class, 'update'])->name('update');
    Route::delete('{courseIntake}', [CourseIntakeController::class, 'destroy'])->name('destroy');
});

// Student Management
Route::prefix('dashboard/students')->name('admin.students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index')->middleware('can:view-students');
    Route::get('/create', [StudentController::class, 'create'])->name('create')->middleware('can:create-student');
    Route::post('/', [StudentController::class, 'store'])->name('store')->middleware('can:create-student');
    Route::get('{student}/edit', [StudentController::class, 'edit'])->name('edit')->middleware('can:update-student');
    Route::put('{student}', [StudentController::class, 'update'])->name('update')->middleware('can:update-student');
    Route::delete('{student}', [StudentController::class, 'destroy'])->name('destroy')->middleware('can:delete-student');
});

// Payment Management
Route::prefix('dashboard/payments')->name('admin.payments.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index')->middleware('can:view-payments');
    Route::get('/create', [PaymentController::class, 'create'])->name('create')->middleware('can:create-payment');
    Route::post('/', [PaymentController::class, 'store'])->name('store')->middleware('can:create-payment');
    Route::get('{payment}/edit', [PaymentController::class, 'edit'])->name('edit')->middleware('can:update-payment');
    Route::put('{payment}', [PaymentController::class, 'update'])->name('update')->middleware('can:update-payment');
    Route::delete('{payment}', [PaymentController::class, 'destroy'])->name('destroy')->middleware('can:delete-payment');
});

// Role Management Overrides
Route::prefix('dashboard/roles')->name('tyro-dashboard.roles.')->group(function () {
    Route::get('/', [LocalRoleController::class, 'index'])->name('index');
    Route::get('/create', [LocalRoleController::class, 'create'])->name('create');
    Route::post('/', [LocalRoleController::class, 'store'])->name('store');
    Route::get('{id}/edit', [LocalRoleController::class, 'edit'])->name('edit');
    Route::put('{id}', [LocalRoleController::class, 'update'])->name('update');
    Route::post('{id}/toggle', [LocalRoleController::class, 'toggleStatus'])->name('toggle');
    Route::delete('{id}', [LocalRoleController::class, 'destroy'])->name('destroy');
});

// Marketing - Lead Management
Route::prefix('dashboard/marketing')->name('admin.marketing.')->group(function () {
    Route::get('leads', [LeadController::class, 'index'])->name('leads.index')->middleware('can:view-leads');
    Route::get('leads/create', [LeadController::class, 'create'])->name('leads.create')->middleware('can:create-lead');
    Route::post('leads', [LeadController::class, 'store'])->name('leads.store')->middleware('can:create-lead');
    Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit')->middleware('can:update-lead');
    Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update')->middleware('can:update-lead');
    Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy')->middleware('can:delete-lead');
});
