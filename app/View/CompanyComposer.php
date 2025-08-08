<?php

namespace App\View;

use Illuminate\View\View;
use App\Models\Company;

class CompanyComposer
{
    public function compose(View $view)
    {
        if (str_starts_with($view->name(), 'auth.')) {
            return;
        }

        $view->with('companies_count', Company::count());
    }
}
