<?php

use App\Enums\IngredientUnit;
use Illuminate\Support\Facades\Artisan;

Artisan::command('dev', function () {
    $user = App\Models\User::first();
    dd($user->email === config('filament.admin') && $this->hasVerifiedEmail());
});
