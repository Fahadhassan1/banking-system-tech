<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use App\Http\Requests\StoreAccountRequest;


class AccountController extends Controller {
    public function index() {
    
        return view('accounts.index');
    }

    public function create() {
        if(auth()->user()->is_admin) {
            $users = User::where('is_admin', 0)
            ->doesntHave('accounts') 
            ->get();
            return view('accounts.create',data: compact('users'));
        }else{
            return redirect()->route('accounts.index');
        }
    }

    public function store(StoreAccountRequest $request) {
    
        // Prepare the data for bulk insert
        $accountsData = [];
        
        foreach ($request->accounts as $account) {
            $accountsData[] = [
                'account_number' => time() . rand(1000, 9999),
                'first_name' => $account['fname'],
                'last_name' => $account['lname'],
                'dob' => $account['dob'],
                'address' => $account['address'],
                'phone' => $account['phone'],
                'currency' => $account['currency'] ?? 'USD',
                'balance' => $account['balance'] ?? 10000,
                'user_id' => $account['user_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Insert multiple records at once
        Account::insert($accountsData);
    
        return redirect()->route('accounts.index')->with('success', 'Accounts created successfully!');
    }
    
}

