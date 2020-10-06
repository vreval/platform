<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function show()
    {
        $query = request()->query('search');
        return ['search_result' => User::where('name', 'like', "%{$query}%")->select(['id', 'name', 'email'])->get()];
    }
}
