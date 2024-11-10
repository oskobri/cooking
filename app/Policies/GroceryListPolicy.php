<?php

namespace App\Policies;

use App\Models\GroceryList;
use App\Models\User;

class GroceryListPolicy
{
    public function view(User $user, GroceryList $groceryList): bool
    {
        return $groceryList->user_id === $user->getKey();
    }

    public function update(User $user, GroceryList $groceryList): bool
    {
        return $this->view($user, $groceryList);
    }

    public function delete(User $user, GroceryList $groceryList): bool
    {
        return $this->view($user, $groceryList);
    }
}
