<?php

use App\Http\Controllers\GroceryListController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientRecipeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('/recipes', RecipeController::class);
Route::resource('/ingredients', IngredientController::class);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/grocery-lists/last', [GroceryListController::class, 'last']);
    Route::resource('/grocery-lists', GroceryListController::class);
    Route::post('/recipes/{recipe}/ingredients/{ingredient?}', [IngredientRecipeController::class, 'store']);
    Route::delete('/recipes/{recipe}/ingredients/{ingredient?}', [IngredientRecipeController::class, 'destroy'])->scopeBindings();
});


