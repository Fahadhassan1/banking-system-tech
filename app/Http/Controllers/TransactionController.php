<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{

    public function index()
    {
        return view('transactions.index');
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'recipient_account_number' => 'required|exists:accounts,account_number',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|in:USD,GBP,EUR',
            'description' => 'nullable|string',
        ]);

        $sender = Auth::user()->getAccounts()->first();  

        $recipient = Account::where('account_number', $request->recipient_account_number)->first();

        if ($sender->account_number === $request->recipient_account_number) {
            return  back()->with('error', 'You cannot transfer funds to the same account.');
        }
        
        if (!$recipient) {
            return back()->with('error', 'Recipient account not found.');
        }

        if ($sender->balance < $request->amount) {
            return back()->with('error', 'Insufficient funds.');
        }

        // Currency conversion
        $exchangeRate = $this->getExchangeRate($sender->currency, $request->currency);
        $convertedAmount = $request->amount * ($exchangeRate ?? 1);

        DB::transaction(function () use ($sender, $recipient, $request, $convertedAmount, $exchangeRate) {
            // Debit sender
            $sender->balance -= $request->amount;
            $sender->save();

            // Credit recipient
            $recipient->balance += $convertedAmount;
            $recipient->save();

            // Record transaction
            Transaction::create([
                'sender_account_id' => $sender->id,
                'receiver_account_id' => $recipient->id,
                'transaction_type' => 'transfer',
                'amount' => $request->amount,
                'currency' => $request->currency,
                'exchange_rate' => $exchangeRate,
                'final_amount' => $convertedAmount,
                'description' =>  $request->description ?? 'Fund transfer',
            ]);
        });

        return back()->with('success', 'Transfer successful.');
    }

    private function getExchangeRate($from, $to)
    {

        if ($from === $to) return 1;

        $apiKey = config('services.exchangeratesapi.key');
        
        $response = Http::get("https://api.exchangeratesapi.io/latest", [
            'access_key' => $apiKey,
            'symbols' => "$from,$to"
        ]);

        $rate = $response->json()['rates'][$to] ?? null;

        return $rate ? $rate * 1.01 : null; // Apply 0.01 spread
    }
}
