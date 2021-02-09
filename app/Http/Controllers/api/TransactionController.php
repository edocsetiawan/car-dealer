<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Stock;
use App\Http\Controllers\Api\TraitApi;

class TransactionController extends Controller
{
    use TraitApi;

    /**
     * add new transaction
     */

     public function addNewTransaction(Request $request)
     {
        $data       = $request->all();  

        $transaction['buyer_name']          = $request['name'];
        $transaction['buyer_email']         = $request['email'];
        $transaction['buyer_phone_number']  = $request['phone_number'];
        $transaction['car_id']              = $request['car_id'];
        $transaction['qty']                 = (int)$request['qty'];
        $transaction['total_price']         = (float)$request['total_price'];

        Stock::where('id',$transaction['car_id'])->decrement('stock',$transaction['qty']);

        Transaction::create($transaction);

        return $this->responseApi('ok','','New stock success insert');
     }
}