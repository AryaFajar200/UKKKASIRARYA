<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;
// use Barryvdh\DomPDF\Facade as PDF;


class TransactionDetailController extends Controller
{
    public function showTransactions()
    {
        $data = TransactionDetail::with(['menu', 'transaction.user'])
                ->orderBy('transaction_id', 'desc')
                ->get();

        return view('Transaction.transactionmenu', compact('data'));
    }

    public function show($transaction_id)
    {
        
        $transactionDetails = TransactionDetail::with('menu')
                            ->where('transaction_id', $transaction_id)
                            ->get();
     
        
        $transactions = Transaction::with('user') // Assuming you have a user relation in your Transaction model
        ->find($transaction_id);

// Extract kasir and order date from the transaction
$kasir = $transactions->user->name ?? 'User Not Found'; // If user relation doesn't exist or user is not found
$tanggalTransaksi = $transactions->order_date;
        
        foreach ($transactionDetails as $detail) {
            $detail->menu->load('discount');
        }

       
    
        // Mengirim data ke view transaction_detail.blade.php untuk ditampilkan
        return view('Transaction.transaction_detail', compact('transactionDetails', 'transactions', 'kasir', 'tanggalTransaksi'));
    }
    










    

}