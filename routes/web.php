<?php
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SectionController;
use App\Livewire\Admin\AboutManager;
use App\Livewire\Admin\EventManager;
use App\Livewire\Admin\GalleryManager;
use App\Livewire\Admin\InquiryManager;
use App\Livewire\Admin\Login as AdminLogin;
use App\Livewire\Admin\MenuManager;
use App\Livewire\Admin\QuestionManager;
use App\Livewire\Admin\QuizLeadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;




// Public one-pager (Vue).
Route::view('/', 'app');
Route::view('/about', 'app');
Route::view('/menu', 'app');


// Admin (Livewire, sidebar layout).
Route::get('/admin/login', AdminLogin::class)->middleware('guest')->name('admin.login');
Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('admin.login');
})->middleware('auth')->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::redirect('/admin', '/admin/questions');
    Route::get('/admin/questions', QuestionManager::class)->name('admin.questions');
    Route::get('/admin/menu', MenuManager::class)->name('admin.menu');
    Route::get('/admin/events', EventManager::class)->name('admin.events');
    Route::get('/admin/inquiries', InquiryManager::class)->name('admin.inquiries');
    Route::get('/admin/quiz-emails', QuizLeadManager::class)->name('admin.quiz-emails');
    Route::get('/admin/about', AboutManager::class)->name('admin.about');
    Route::get('/admin/gallery', GalleryManager::class)->name('admin.gallery');
    });

Route::prefix('api')->group(function () {
    Route::get('quiz', [QuizController::class, 'index']);
    Route::post('quiz/result', [QuizController::class, 'result'])->middleware('throttle:30,1');
    Route::post('quiz/email', [QuizController::class, 'emailResult'])->middleware('throttle:10,1');
    Route::post('contact', [InquiryController::class, 'store'])->middleware('throttle:5,1');
    Route::get('sections/{key}', [SectionController::class, 'show']);
    Route::get('gallery', [GalleryController::class, 'index']);
    Route::get('menu', [MenuController::class, 'index']);   // <- no "/api/" here
});


