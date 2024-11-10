<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function me(): UserResource
    {
        return UserResource::make(auth()->user());
    }
}
