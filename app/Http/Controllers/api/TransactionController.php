<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Stock;
use App\Http\Controllers\Api\TraitApi;
use App\Mail\CarDealerEmail;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    use TraitApi;

    /**
     * add new transaction
     */

     public function addNewTransaction(Request $request)
     {
         $data       = $request->all();  
         $user       = Auth::user();
         $car_data   = Stock::where('id',$request['car_id'])->first();  
         $transaction['buyer_name']          = $request['name'];
         $transaction['buyer_email']         = $request['email'];
         $transaction['buyer_phone_number']  = $request['phone_number'];
         $transaction['car_id']              = $request['car_id'];
         $transaction['qty']                 = (int)$request['qty'];
         $transaction['total_price']         = (int)$request['qty'] * $car_data->price;
         $transaction['total_price_format']  = 'Rp.' . number_format($request['total_price'],0, ',' , '.');
         $transaction['car_name']            = $car_data->car_name;
         Transaction::create($transaction);
         Stock::where('id',$transaction['car_id'])->decrement('stock',$transaction['qty']);

         Mail::send('templateEmail', $transaction, function($message) use($transaction,$user) {
            $message->to($transaction['buyer_email'], $transaction['buyer_name'])->subject('Invoice');
            $message->from($user['email'],$user['name']);
         });

        return $this->responseApi('ok','','New stock success insert');
     }
}
