<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LeaderboardController;
use App\Http\Controllers\Web\MatchController;
use App\Http\Controllers\Web\PlayerController;
use App\Http\Controllers\Web\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('players', PlayerController::class)->except(['create', 'show']);
Route::resource('matches', MatchController::class)->except(['edit', 'update']);
Route::post('matches/{match}/rounds', [RoundController::class, 'store'])->name('matches.rounds.store');
Route::get('leaderboard', LeaderboardController::class)->name('leaderboard');
