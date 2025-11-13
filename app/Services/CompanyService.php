<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CompanyService
{

    public function getAllCompanies(): Collection
    {
        return Company::with(['address', 'contacts'])->get();
    }

    public function findCompanyById(int $id): ?Company
    {
        return Company::with(['address', 'contacts'])->find($id);
    }


    public function create(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            $company = Company::create($this->onlyCompanyFields($data));

            $this->upsertAddress($company, $data);

            $this->syncContacts($company, $data['contacts'] ?? []);

            return $company->load(['address', 'contacts']);
        });
    }


    public function update(Company $company, array $data): Company
    {
        return DB::transaction(function () use ($company, $data) {
            $company->update($this->onlyCompanyFields($data));

            $this->upsertAddress($company, $data);
            $this->syncContacts($company, $data['contacts'] ?? []);

            return $company->load(['address', 'contacts']);
        });
    }

    public function delete(Company $company): void
    {
        try {
            DB::transaction(function () use ($company) {
                $company->contacts()->delete();
                $company->address()->delete();

                $company->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete company.", 500, $e);
        }
    }


    private function onlyCompanyFields(array $data): array
    {
        return Arr::only($data, [
            'name',
            'trade_name',
            'registration_number',
        ]);
    }

    private function onlyAddressFields(array $data): array
    {
        return Arr::only($data, [
            'street',
            'number',
            'complement',
            'neighborhood',
            'city',
            'state',
            'zip_code',
        ]);
    }

    private function upsertAddress(Company $company, array $data): void
    {
        $addressPayload = $this->onlyAddressFields($data);

        if ($company->address) {
            $company->address()->update($addressPayload);
        } else {
            $company->address()->create($addressPayload);
        }
    }


    private function syncContacts(Company $company, array $contacts): void
    {
        $existingIds = $company->contacts()->pluck('id')->all();

        $incomingIds = array_values(array_filter(
            array_map(fn($c) => $c['id'] ?? null, $contacts),
            fn($id) => !is_null($id)
        ));

        $idsToDelete = array_diff($existingIds, $incomingIds);
        if (!empty($idsToDelete)) {
            $company->contacts()->whereIn('id', $idsToDelete)->delete();
        }

        foreach ($contacts as $contact) {
            $payload = Arr::only($contact, ['name', 'email', 'phone']);

            if (!empty($contact['id'])) {
                $model = $company->contacts()->find($contact['id']);
                if (!$model) {
                    throw new ModelNotFoundException("Contato id={$contact['id']} não encontrado.");
                }
                $model->update($payload);
            } else {
                $company->contacts()->create($payload);
            }
        }
    }
}
