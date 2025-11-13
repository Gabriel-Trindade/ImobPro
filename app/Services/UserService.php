<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    public function create($request)
    {

        return DB::transaction(function () use ($request) {
            $data = $request->only(['name', 'email', 'password', 'type']);
            $data['company_id'] = $this->company_id;

            if ($data['type'] === 'agent') {
                $data['license_number'] = $request->input('license_number', null);
            }

            $data['password'] = bcrypt($data['password']);

            return User::create($data);
        });
    }

    public function update($request, $user)
    {

        return DB::transaction(function () use ($request, $user) {
            $data = $request->only(['name', 'email', 'password', 'type']);
            $data['company_id'] = $this->company_id;

            if ($data['type'] === 'agent') {
                $data['license_number'] = $request->input('license_number', null);
            }

            $data['password'] = bcrypt($data['password']);

            return $user->update($data);
        });
    }


}
