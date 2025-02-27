<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class StoreAccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_stores_multiple_accounts_successfully()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();

        $accountsData = [
            [
                'fname' => 'John',
                'lname' => 'Doe',
                'dob' => '1980-05-15',
                'address' => '123 Main St, City, Country',
                'phone' => '1234567890',
                'currency' => 'USD',
                'balance' => 10000,
                'user_id' => $user->id,
            ],
            [
                'fname' => 'Jane',
                'lname' => 'Smith',
                'dob' => '1990-08-20',
                'address' => '456 Elm St, City, Country',
                'phone' => '0987654321',
                'currency' => 'EUR',
                'balance' => 5000,
                'user_id' => $user1->id,
            ],
        ];

        $response = $this->actingAs($user)->post(route('accounts.store'), [
            'accounts' => $accountsData,
        ]);

        $response->assertRedirect(route('accounts.index'));

        $response->assertSessionHas('success', 'Accounts created successfully!');

        foreach ($accountsData as $account) {
            $this->assertDatabaseHas('accounts', [
                'first_name' => $account['fname'],
                'last_name' => $account['lname'],
                'dob' => $account['dob'],
                'address' => $account['address'],
                'phone' => $account['phone'],
                'currency' => $account['currency'],
                'balance' => $account['balance'],
                'user_id' => $account['user_id'],
            ]);
        }

        $this->assertCount(count($accountsData), Account::all());
    }
}

