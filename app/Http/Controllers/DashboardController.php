<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $company_id;
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
        $this->company_id = Auth::user()->company_id;
        $this->middleware(['agent', 'admin']);
    }

    public function index()
    {
        if ($this->user->isAdmin()) {
            return view('dashboard.admin', ['company_id' => $this->company_id]);
        } elseif ($this->user->isAgent()) {
            return view('dashboard.agent', ['company_id' => $this->company_id]);
        }

        return redirect('/auth/login')->with('error', 'Acesso não autorizado.');
    }
}
