<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller {
    public function index() {
        return view('accounts.index');
    }

    public function create() {
        $users=User::where('is_admin',0)->get();
        return view('accounts.create',compact('users'));
    }

    public function store(Request $request) {
        // Validate each account entry
        $request->validate([
            'accounts' => 'required|array|min:1', 
            'accounts.*.fname' => 'required|string|max:255',
            'accounts.*.lname' => 'required|string|max:255',
            'accounts.*.dob' => 'required|date',
            'accounts.*.address' => 'required|string',
            'accounts.*.phone' => 'required|string',
            'accounts.*.currency' => 'required|in:USD,GBP,EUR',
            'accounts.*.user_id' => 'required|exists:users,id|distinct',
            'accounts.*.balance' => 'required|numeric',

        ]);
    
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

