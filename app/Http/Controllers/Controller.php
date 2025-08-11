<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $company_id = null;
    protected $user = null;
    public function __construct()
    {
        $this->user = Auth::user();
        $this->company_id = Auth::user()->company_id ?? null;

        if (!$this->user) {
            return redirect()->route('login');
        }
    }

    protected function getCompanyId()
    {
        return $this->company_id;
    }

    protected function getUser()
    {
        return $this->user;
    }

}
