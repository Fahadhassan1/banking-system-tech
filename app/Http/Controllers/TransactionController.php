<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\TransferRequest;
use App\Services\ExchangeRateService;



class TransactionController extends Controller
{

    protected $exchangeRateService;
    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

     /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $account_id = null)
    {
        $accountid = $account_id;;
        return view('transactions.index', compact('account_id'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function transfer(TransferRequest $request)
    {
      
        $sender = Auth::user()->accounts()->first();

        $recipient = Account::where('account_number', $request->recipient_account_number)->first();

        if (!$sender) {
            return back()->with('error', 'You dont have Saving Account Yet! Sender account not found.');
        }
        if ($sender->account_number == $request->recipient_account_number) {
            return  back()->with('error', 'You cannot transfer funds to the same account.');
        }
        
        if (!$recipient) {
            return back()->with('error', 'Recipient account not found.');
        }

        if ($sender->balance < $request->amount) {
            return back()->with('error', 'Insufficient funds.');
        }

        // Currency conversion service
        $exchangeRate = $this->exchangeRateService->getRate($sender->currency, $request->currency);
        if ($exchangeRate === null) {
            return back()->with('error', 'Unable to fetch exchange rate. Please try again later.');
        }
        $convertedAmount = $request->amount * ($exchangeRate ?? 1);

        DB::transaction(function () use ($sender, $recipient, $request, $convertedAmount, $exchangeRate) {
            // Debit sender
            $sender->balance -= $request->amount;
            $sender->save();

            // Credit recipient
            $recipient->balance += $convertedAmount;
            $recipient->save();

            // Store transaction
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


}
