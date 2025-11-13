<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use Illuminate\Support\Facades\Log;
use function Pest\Laravel\withoutExceptionHandling;

uses(RefreshDatabase::class)->group('company');

it('creates a company with address and contacts', function () {
    withoutExceptionHandling();

    $user = User::factory()->create();

    $payload = [
        'name' => 'EMPRESA',
        'trade_name' => 'EMPRESA LTDA',
        'registration_number' => '07865924000108',
        'address' => [
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '01001000',
            'street' => 'Praça da Sé',
            'number' => '100',
            'complement' => 'Sala 101',
            'neighborhood' => 'Sé',
        ],
        'contacts' => [
            [
                'type' => 'sales',
                'email' => 'a@b.com',
                'phone' => '33333333',
                'instagram' => 'https://www.instagram.com/@empresa',
                'facebook' => 'https://facebook.com/empresa.sales',
                'olx' => 'https://olx.com.br/empresa.sales',
                'website' => 'https://www.empresa.com',
            ]
        ],
    ];

    $resp = actingAs($user)->post(route('companies.store'), $payload);

    $resp->assertStatus(302);
    $resp->assertSessionHasNoErrors();

    Log::info('Após o post para CompaniesController@store', ['response' => $resp->getContent()]);

    assertDatabaseHas('companies', ['name' => 'EMPRESA']);

    $resp->assertRedirect(route('companies.index'));

    assertDatabaseHas('company_addresses', ['city' => 'São Paulo']);
});
