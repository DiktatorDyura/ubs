<?php

use App\Http\Controllers\ProfileController;
use App\Models\NotableLessons;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotableLessonsController;

use App\Http\Controllers\LessonController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AnnouncementController;

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

Route::get('/forbidden', function () {
    return view('forbidden');
})->name('forbidden');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/calendar', [LessonController::class, 'index'])->name('profile.calendar');//dersleri gösterir
    Route::get('/profile/announcment', [AnnouncementController::class, 'index'])->name('profile.announcment');

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});

require __DIR__ . '/auth.php';



Route::middleware(['auth', 'pages:adminandteacher'])->group(function () {
    Route::get('/profile/listuser', [RegisteredUserController::class, 'show'])->name('profile.listuser');
    Route::post('/profile/deleteuser', [RegisteredUserController::class, 'delete'])->name('profile.deleteuser');

    Route::post('/notablelessons', [NotableLessonsController::class, 'store'])->name('notablelessons.create');
    Route::get('/notablelessons', [NotableLessonsController::class, 'index'])->name('notablelessons');
    Route::post('/notablelessonsdestroy', [NotableLessonsController::class, 'destroy'])->name('notablelessonsdestroy');




    Route::get('/profile/adduser', [RegisteredUserController::class, 'create']);
    Route::post('/profile/adduser', [RegisteredUserController::class, 'store'])->name('profile.adduser');



    Route::get('/admin/list/lesson', [LessonController::class, 'show'])->name('admin.list.lesson');
    Route::post('/admin/list/lesson', [LessonController::class, 'delete'])->name('admin.list.lesson');

    Route::post('/admin/add/lesson', [LessonController::class, 'store'])->name('admin.add.lesson');
    Route::get('/admin/add/lesson', function () {
        return view('admin.add.lesson');
    })->name('admin.add.lesson');

    Route::get('/admin/add/announcment', function () {
        return view('admin.add.announcment');
    })->name('admin.add.announcment');//dyr+

    Route::post('/admin/add/announcment', [AnnouncementController::class, 'store'])->name('admin.add.anouncment');




    Route::get('/profile/list/lesson', [LessonController::class, 'index'])->name('profile.list.lesson');
    Route::post('/profile/list/lesson', [LessonController::class, 'create'])->name('admin.dashboard');
    Route::delete('/profile/list/lesson', [LessonController::class, 'destroy'])->name('admin.dashboard');
});




