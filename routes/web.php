<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;

Route::get('/', function () {
    return view('welcome');
});

// Issues list
Route::get('/', [IssueController::class, 'index'])->name('issues.index');

// Issue details
Route::get('/issue/{owner}/{repo}/{issue}', [IssueController::class, 'show'])
    ->where('issue', '[0-9]+')
    ->name('issues.show');