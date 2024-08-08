<?php

namespace App\Repositories\Admin;

use App\Models\User;

class UserRepository
{

    public function all(){
        return User::all();
    }

}
