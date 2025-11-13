<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $company_id;
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
        $this->company_id = Auth::user()->company_id ?? null;
    }
    public function getAllUsers()
    {
        return User::where('company_id', $this->company_id)->get();
    }
}
