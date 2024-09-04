<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientRecipeController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::resource('/recipes', RecipeController::class);
Route::resource('/ingredients', IngredientController::class);
Route::post('/ingredients/{ingredient}/recipes/{recipe}', [IngredientRecipeController::class, 'store']);
Route::delete('/ingredients/{ingredient}/recipes/{recipe}', [IngredientRecipeController::class, 'destroy'])->scopeBindings();
