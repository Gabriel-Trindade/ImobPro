<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    protected $company_id;
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
        $this->company_id = Auth::user()->company_id ?? null;
    }

    public function index()
    {
        return view('users.index');
    }
}
