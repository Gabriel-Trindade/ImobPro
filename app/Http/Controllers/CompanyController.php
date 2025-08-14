<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $companies) {}

    public function index(): View
    {
        $companies = $this->companies->getAllCompanies();
        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.register');
    }

    public function edit(Company $company): View
    {
        $company->load('address', 'contacts');
        return view('companies.register', compact('company'));
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->companies->create($request->all());
        return to_route('companies.index')->with('success', 'Empresa criada com sucesso!');
    }

    public function update(StoreCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->companies->update($company, $request->all());
        return to_route('companies.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function destroy(Company $company): RedirectResponse
    {
        try {
            $this->companies->delete($company);

            $company->refresh();
            return to_route('companies.index')->with(
                $company->trashed() ? 'success' : 'error',
                $company->trashed() ? 'Empresa excluída com sucesso!' : 'Falha ao excluir empresa.'
            );
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Falha ao excluir empresa: ' . $e->getMessage());
        }
    }
}
