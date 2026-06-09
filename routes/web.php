<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Public Routes — accessible without authentication
|--------------------------------------------------------------------------
*/
Route::get('/login',  [LoginController::class,  'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,  'login']);

Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// AUTHENTICATION — logout requires POST to prevent CSRF-based forced logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHORIZATION — All routes below require a logged-in user
| Original code: only /home was protected; all others were publicly accessible
| Fix: wrap every sensitive route in auth middleware group
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Home / Dashboard
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/', function () {
        return redirect()->route('home');
    });

    // ── Invoices / Billing ──────────────────────────────────────────────
    Route::get('/billing-list',          [InvoiceController::class, 'index'])->name('billing-list');
    Route::get('/create-invoice',        [InvoiceController::class, 'create'])->name('create-invoice');
    Route::post('/invoices',             [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoice/{id}',          [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{id}/edit',     [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{id}/update',   [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{id}',       [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    // ── Doctors ─────────────────────────────────────────────────────────
    Route::get('/doctor',            [DoctorController::class, 'index'])->name('doctor');
    Route::get('/add-doctor',        [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/add-doctor',       [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/doctor/{id}/edit',  [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/doctor/{id}',       [DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/doctor/{id}',    [DoctorController::class, 'destroy'])->name('doctor.destroy');

    // ── Pharmacy / Drugs ─────────────────────────────────────────────────
    Route::get('/pharmacy',                  [DrugController::class, 'index'])->name('pharmacy');
    Route::get('/pharmacy/add-drug',         [DrugController::class, 'create'])->name('add-drug');
    Route::post('/pharmacy/store',           [DrugController::class, 'store'])->name('store-drug');
    Route::get('/pharmacy/edit-drug/{id}',   [DrugController::class, 'edit'])->name('edit-drug');
    Route::put('/pharmacy/update/{id}',      [DrugController::class, 'update'])->name('update-drug');
    Route::delete('/pharmacy/delete/{id}',   [DrugController::class, 'destroy'])->name('delete-drug');

    // ── Medical Records ──────────────────────────────────────────────────
    Route::get('/medical',           [MedicalController::class, 'index'])->name('medical');
    Route::get('/view-medical',      [MedicalController::class, 'view_more'])->name('medical.view_more');
    Route::get('/add-medical',       [MedicalController::class, 'create'])->name('medical.create');
    Route::post('/view-medical',     [MedicalController::class, 'store'])->name('medical.store');
    Route::get('/medical/{id}/edit', [MedicalController::class, 'edit'])->name('medical.edit');
    Route::put('/medical/{id}',      [MedicalController::class, 'update'])->name('medical.update');
    Route::delete('/medical/{id}',   [MedicalController::class, 'destroy'])->name('medical.destroy');

    // ── Patients ─────────────────────────────────────────────────────────
    Route::get('/patients',              [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/search',       [PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/create',       [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients',             [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}/edit',    [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{id}',         [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}',      [PatientController::class, 'destroy'])->name('patients.destroy');

    // ── Appointments ──────────────────────────────────────────────────────
    Route::get('/appointments',              [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create',       [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',             [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}/edit',    [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{id}',         [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}',      [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});
