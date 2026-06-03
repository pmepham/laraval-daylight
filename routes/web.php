<?php

use App\Http\Controllers\AssessmentFrameworkBuilderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingsAccountsController;
use App\Http\Controllers\SettingsAssessmentsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SettingsGeneralController;
use App\Http\Controllers\SettingsSitesController;
use App\Http\Middleware\DecryptIdMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients', [DashboardController::class, 'index'])->name('clients');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::post('/bookings/create', [BookingController::class, 'index'])->name('bookings');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/settings/general', [SettingsGeneralController::class, 'general'])->name('settings.general');
    Route::put('/settings/general/update', [SettingsGeneralController::class, 'updateSingleColumn'])->name('settings.general.update');
    //account settings endpoints
    Route::get('/settings/accounts', [SettingsAccountsController::class, 'accounts'])->name('settings.accounts');
    Route::get('/settings/accounts/data', [SettingsAccountsController::class, 'accountsDataTable'])->name('settings.accounts.data');
    Route::post('/settings/accounts/create', [SettingsAccountsController::class, 'createAccount'])->name('settings.accounts.create');

    Route::get('/settings/accounts/edit/{id}', [SettingsAccountsController::class, 'showAccountEditModal'])->name('settings.accounts.edit')->middleware(DecryptIdMiddleware::class);
    Route::put('/settings/accounts/update/{id}', [SettingsAccountsController::class, 'updateAccount'])->name('settings.accounts.update')->middleware(DecryptIdMiddleware::class);
    Route::delete('/settings/accounts/delete/{id}', [SettingsAccountsController::class, 'deleteAccount'])->name('settings.accounts.delete')->middleware(DecryptIdMiddleware::class);

        Route::delete('/settings/assessments/framework/question', [AssessmentFrameworkBuilderController::class, 'deleteAssessmentFrameworkQuestion'])
            ->name('assessment.framework.builder.delete.question');

    //assessment settings endpoints
    Route::get('/settings/assessments', [SettingsAssessmentsController::class, 'assessments'])->name('settings.assessments');
    Route::get('/settings/assessments/framework/data', [SettingsAssessmentsController::class, 'assessmentFrameworksDataTable'])->name('settings.assessment.framework.data');
    Route::post('/settings/assessments/framework/create', [SettingsAssessmentsController::class, 'createAssessmentFramework'])->name('settings.assessment.framework.create');
    Route::delete('/settings/assessments/framework/{id}', [SettingsAssessmentsController::class, 'deleteAssessmentFramework'])->name('settings.assessment.framework.delete');

    //assessment framework builder endpoints
    Route::get('/settings/assessments/framework/{id}', [AssessmentFrameworkBuilderController::class, 'assessmentFrameworkBuilder'])->name('assessment.framework.builder')->middleware(DecryptIdMiddleware::class);
    
    Route::post('/settings/assessments/framework/{id}/question/create', [AssessmentFrameworkBuilderController::class, 'createAssessmentFrameworkQuestion'])
            ->name('assessment.framework.builder.create.question')->middleware(DecryptIdMiddleware::class);



    //site settings endpoints
    Route::get('/settings/sites', [SettingsSitesController::class, 'sites'])->name('settings.sites');
    Route::get('/settings/sites/data', [SettingsSitesController::class, 'sitesDataTable'])->name('settings.sites.data');
    Route::post('/settings/sites/create', [SettingsSitesController::class, 'createSite'])->name('settings.sites.create');
    Route::get('/settings/sites/edit/{id}', [SettingsSitesController::class, 'showSiteEditModal'])->name('settings.sites.edit')->middleware(DecryptIdMiddleware::class);
    Route::put('/settings/sites/update/{id}', [SettingsSitesController::class, 'updateSite'])->name('settings.sites.update')->middleware(DecryptIdMiddleware::class);
    Route::delete('/settings/sites/delete/{id}', [SettingsSitesController::class, 'deleteSite'])->name('settings.sites.delete')->middleware(DecryptIdMiddleware::class);

});

Route::middleware('guest')->group(function () {
    //login endpoints
    Route::get('/', [LoginController::class, 'index']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-attempt', [LoginController::class, 'authenticate'])->name('login.authenticate');
    //registration endpoints
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register-attempt', [RegisterController::class, 'authenticate'])->name('register.authenticate');
});

