<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct(private UserService $users) {}
    public function index()
    {
        $users = $this->users->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.register');
    }

    public function edit(User $user)
    {
        return view('users.register', compact('user'));
    }

    public function store(Request $request)
    {
        $this->users->create($request);

        return redirect()->route('users.index');
    }

    public function update(Request $request, User $user)
    {
        $this->users->update($request, $user);
        return redirect()->route('users.index');
    }
}
