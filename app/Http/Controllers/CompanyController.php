<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{

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

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $company->load('address', 'contacts');

        return view('companies.register', compact('company'));
    }

    public function store(Request $request)
    {
        $this->_validate($request);

        try {
            DB::transaction(function () use ($request) {

                $company = Company::create([
                    'name' => $request->string('name'),
                    'trade_name' => $request->string('trade_name'),
                    'registration_number' => $request->string('registration_number'),
                ]);

                $company->address()->create([
                    'street'       => $request->string('address'),
                    'number'       => $request->string('number'),
                    'complement'   => $request->input('complement'),
                    'neighborhood' => $request->string('neighborhood'),
                    'city'         => $request->string('city'),
                    'state'        => $request->string('state'),
                    'zip_code'     => $request->string('zip_code'),
                ]);

                $contacts = $request->input('contacts', []);
                foreach ($contacts as $contact) {
                    if (!is_array($contact)) {
                        continue;
                    }

                    $company->contacts()->create([
                        'email'     => $contact['email']     ?? null,
                        'instagram' => $contact['instagram'] ?? null,
                        'facebook'  => $contact['facebook']  ?? null,
                        'olx'       => $contact['olx']       ?? null,
                        'website'   => $contact['website']   ?? null,
                        'type'      => $contact['type']      ?? null,
                    ]);
                }
            });

            return redirect()
                ->route('companies.index')
                ->with('success', 'Empresa criada com sucesso!');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors('Não foi possível criar a empresa. Tente novamente.');
        }
    }

    public function update(Request $request, Company $company)
    {
        $this->_validate($request);

        try {
            DB::transaction(function () use ($request, $company) {
                $company->update([
                    'name' => $request->string('name'),
                    'trade_name' => $request->string('trade_name'),
                    'registration_number' => $request->string('registration_number'),
                ]);

                $company->address()->update([
                    'street'       => $request->string('address'),
                    'number'       => $request->string('number'),
                    'complement'   => $request->input('complement'),
                    'neighborhood' => $request->string('neighborhood'),
                    'city'         => $request->string('city'),
                    'state'        => $request->string('state'),
                    'zip_code'     => $request->string('zip_code'),
                ]);

                $contacts = $request->input('contacts', []);
                foreach ($contacts as $contact) {
                    if (!is_array($contact)) {
                        continue;
                    }

                    $company->contacts()->update([
                        'email'     => $contact['email']     ?? null,
                        'instagram' => $contact['instagram'] ?? null,
                        'facebook'  => $contact['facebook']  ?? null,
                        'olx'       => $contact['olx']       ?? null,
                        'website'   => $contact['website']   ?? null,
                        'type'      => $contact['type']      ?? null,
                    ]);
                }
            });

            return redirect()
                ->route('companies.index')
                ->with('success', 'Empresa atualizada com sucesso!');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors('Não foi possível atualizar a empresa. Tente novamente.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $company = Company::findOrFail($id);
                $company->contacts()->delete();
                $company->address()->delete();
                $company->delete();
            });

            return redirect()
                ->route('companies.index')
                ->with('success', 'Empresa excluída com sucesso!');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors('Não foi possível excluir a empresa. Tente novamente.');
        }
    }

    private function _validate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trade_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:18',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'complement' => 'nullable|string|max:255',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);
    }
}
