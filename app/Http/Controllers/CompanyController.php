<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
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
        $companies = Company::all();

        return view('companies.index', with(
            [
                'companies' => $companies
            ]
        ));
    }

    public function create()
    {
        return view('companies.register');
    }

}
