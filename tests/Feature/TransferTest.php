<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    protected $exchangeRateService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exchangeRateService = Mockery::mock('App\Services\ExchangeRateService');
        $this->app->instance('App\Services\ExchangeRateService', $this->exchangeRateService);
    }

    public function test_successful_transfer()
    {
        $senderUser = User::factory()->create();
        $senderAccount = Account::factory()->create([
            'user_id' => $senderUser->id,
            'balance' => 1000,
            'currency' => 'USD'
        ]);

        $recipientAccount = Account::factory()->create([
            'balance' => 500,
            'currency' => 'EUR'
        ]);

        Auth::login($senderUser);

        $this->exchangeRateService->shouldReceive('getRate')
            ->with('USD', 'EUR')
            ->andReturn(0.85);

        $response = $this->post('/transfer', [
            'recipient_account_number' => $recipientAccount->account_number,
            'amount' => 100,
            'currency' => 'EUR',
            'description' => 'Test transfer'
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Transfer successful.');

        $this->assertEquals(900, $senderAccount->fresh()->balance);
        $this->assertEquals(585, $recipientAccount->fresh()->balance);

        $this->assertDatabaseHas('transactions', [
            'sender_account_id' => $senderAccount->id,
            'receiver_account_id' => $recipientAccount->id,
            'amount' => 100,
            'currency' => 'EUR',
            'exchange_rate' => 0.85,
            'final_amount' => 85,
            'description' => 'Test transfer'
        ]);
    }

    public function test_insufficient_funds()
    {
        $senderUser = User::factory()->create();
        $senderAccount = Account::factory()->create([
            'user_id' => $senderUser->id,
            'balance' => 50,
            'currency' => 'USD'
        ]);

        $recipientAccount = Account::factory()->create([
            'balance' => 500,
            'currency' => 'EUR'
        ]);

        Auth::login($senderUser);

        $response = $this->post('/transfer', [
            'recipient_account_number' => $recipientAccount->account_number,
            'amount' => 100,
            'currency' => 'EUR',
            'description' => 'Test transfer'
        ]);

        $response->assertRedirect()
            ->assertSessionHas('error', 'Insufficient funds.');

        $this->assertEquals(50, $senderAccount->fresh()->balance);
        $this->assertEquals(500, $recipientAccount->fresh()->balance);
    }

    public function test_transfer_to_same_account()
    {
        $senderUser = User::factory()->create();
        $senderAccount = Account::factory()->create([
            'user_id' => $senderUser->id,
            'balance' => 1000,
            'currency' => 'USD'
        ]);

        Auth::login($senderUser);

        $response = $this->post('/transfer', [
            'recipient_account_number' => $senderAccount->account_number,
            'amount' => 100,
            'currency' => 'USD',
            'description' => 'Test transfer'
        ]);

        $response->assertRedirect()
            ->assertSessionHas('error', 'You cannot transfer funds to the same account.');

        $this->assertEquals(1000, $senderAccount->fresh()->balance);
    }


    public function test_unable_to_fetch_exchange_rate()
    {
        $senderUser = User::factory()->create();
        $senderAccount = Account::factory()->create([
            'user_id' => $senderUser->id,
            'balance' => 1000,
            'currency' => 'USD'
        ]);

        $recipientAccount = Account::factory()->create([
            'balance' => 500,
            'currency' => 'EUR'
        ]);

        Auth::login($senderUser);

        $this->exchangeRateService->shouldReceive('getRate')
            ->with('USD', 'EUR')
            ->andReturn(null);  

        $response = $this->post('/transfer', [
            'recipient_account_number' => $recipientAccount->account_number,
            'amount' => 100,
            'currency' => 'EUR',
            'description' => 'Test transfer'
        ]);

        $response->assertRedirect()
            ->assertSessionHas('error', 'Unable to fetch exchange rate. Please try again later.');

        $this->assertEquals(1000, $senderAccount->fresh()->balance);
        $this->assertEquals(500, $recipientAccount->fresh()->balance);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
