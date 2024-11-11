<?php

use App\Actions\AuthenticateWithToken;
use App\Http\Controllers\GroceryListController;
use App\Http\Controllers\GroceryListRecipeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeFavoriteController;
use App\Http\Controllers\RecipeGuestController;
use App\Http\Controllers\RecipeRatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', AuthenticateWithToken::class);

Route::get('/recipes-guest', [RecipeGuestController::class, 'index']);
Route::get('/recipes-guest/{recipe}', [RecipeGuestController::class, 'show']);

// Todo later
//Route::resource('/ingredients', IngredientController::class);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/users/me', [UserController::class, 'me']);

    Route::resource('/recipes', RecipeController::class);

    Route::post('/recipes/{recipe}/ratings', [RecipeRatingController::class, 'rate']);
    Route::post('/recipes/{recipe}/favorites', RecipeFavoriteController::class);

    Route::get('/grocery-lists/last', [GroceryListController::class, 'last']);
    Route::resource('/grocery-lists', GroceryListController::class);
    Route::put('/grocery-lists/{grocery_list}/recipes/{recipe}', [GroceryListRecipeController::class, 'update'])->scopeBindings();

    // TODO later
    //Route::post('/recipes/{recipe}/ingredients/{ingredient?}', [IngredientRecipeController::class, 'store']);
    //Route::delete('/recipes/{recipe}/ingredients/{ingredient?}', [IngredientRecipeController::class, 'destroy'])->scopeBindings();
});





