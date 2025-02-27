<?php

namespace App\Http\Controllers;

use App\Models\Account; // Use your model here
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;


class DataTableController extends Controller
{
    // Fetch the data for Savings Accounts DataTable
    function get_saving_accounts(Request $request){


        if ($request->ajax()) {

            $accounts = Auth::user()->getAccounts();  
    
            return Datatables::of($accounts)
                ->editColumn('account_number', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .'ACC-'.$account->account_number.'</p>');
                })
                ->editColumn('first_name', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .$account->first_name.'</p>');
                })
                ->editColumn('last_name', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .$account->last_name.'</p>');
                })
                ->editColumn('dob', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .date('d M Y', strtotime($account->dob)).'</p>');
                })
            
        
                ->editColumn('balance', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . number_format($account->balance,'0') .'</p>');
                })
                ->editColumn('created_at', function($account) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .date('d M Y H:m:i', strtotime($account->created_at)).'</p>');
                })
                ->editColumn('status', function($user) {
                    // Determine the status class and title
                    $class = $user->status == 1 ? 'text-success' : 'text-danger';
                    $title = $user->status == 1 ? 'active' : 'inactive';
                    $statusHtml = '<span  class="w-400 f-size-12 text-center status ' . $class . '">' . ucwords($title) . '</span>';
                    return new HtmlString( $statusHtml);
                })

                ->editColumn('action', function($user) {
                    $html = '<a href="' . route('transactions.index') . '" class="btn btn-primary btn-sm">View Transaction</a>';
                    return new HtmlString($html);
                })->make(true);

        }

    }


    // Fetch the data for Transaction for each Account DataTable
    function get_transactions(Request $request){


        if ($request->ajax()) {


            $accounts = Auth::user()->getAccounts()->first();  
            

            $transactions = Transaction::where('sender_account_id', $accounts->id)
            ->orWhere('receiver_account_id', $accounts->id)
            ->orderBy('created_at', 'desc')
            ->get();

            return Datatables::of($transactions)
                
                ->editColumn('transaction_type', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .ucwords($transaction->transaction_type).'</p>');
                })
                ->editColumn('amount', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . number_format($transaction->amount,'0') .'</p>');
                })
                ->editColumn('currency', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . $transaction->currency .'</p>');
                })
                ->editColumn('exchange_rate', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . number_format($transaction->exchange_rate,'2') .'</p>');
                })
                ->editColumn('final_amount', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . number_format($transaction->final_amount,'0') .'</p>');
                })
                ->editColumn('description', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' . $transaction->description .'</p>');
                })
                ->editColumn('created_at', function($transaction) {
                    return new HtmlString('<p class="datatable-user-data w-400 f-size-14 color-1 proxima">' .date('d M Y H:m:i', strtotime($transaction->created_at)).'</p>');
                })
                
                ->make(true);

        }

    }
}

