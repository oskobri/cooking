<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    public function view(?User $user, Recipe $recipe): bool
    {
        return $user
            ? $recipe->published && ($recipe->public || $recipe->user_id === $user->getKey())
            : $recipe->published && $recipe->public;
    }

    public function update(User $user, Recipe $recipe): bool
    {
        return $recipe->user_id === $user->getKey();
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $this->update($user, $recipe);
    }
}
