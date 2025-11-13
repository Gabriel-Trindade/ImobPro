<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    public function __construct(private UserService $users)
    {}
    public function index()
    {
        $users = $this->users->getAllUsers();
        return view('users.index', compact('users'));
    }
}
