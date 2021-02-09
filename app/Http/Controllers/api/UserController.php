<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TraitApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Stock;
use DB;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    use TraitApi;
    /**
     * login function
     */
    public function login()
    {
        if(Auth::attempt(['email' => request('email'),'password' => request('password')])){
            $username = Auth::user();
            $username['token'] = $username->createToken('nApp')->accessToken;
            return $this->responseApi('ok',$username,'Login Success');
        }else{
            return $this->responseApi('error','','Something went wrong');
        }
    }

    /**
     * register username 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'email'             => 'required|email',
            'password'          => 'required',
            'confirm_password'  => 'required|same:password',
        ]);
        if($validator->fails()){
            return $this->responseApi('error','',$validator->errors());
        }

        $data               = $request->all();
        $data['password']   = bcrypt($data['password']);
        $user               = User::create($data);
        $msg['token']       = $user->createToken('nApp')->accessToken;
        $msg['name']        = $user->name;
        
        return $this->responseApi('ok',$msg,'Register success');
    }

    /**
     * logout user
     */
    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        if($logout){
            return $this->responseApi('ok','','Successfully log out');
        }else{
            return $this->responseApi('error','','Something went wrong');
        }
    }

    /**
     * detail user
     */
    public function userDetail()
    {
        $user['data'] = Auth::user();

        $query                  =   Transaction::join('stock','transaction.car_id','stock.id')
                                    ->select('stock.car_name',DB::raw('COUNT(car_id) as count'),DB::raw('SUM(total_price) as price'))
                                    ->groupBy('stock.car_name')
                                    ->orderBy('price', 'desc');
        $clone1 = clone $query;
        $clone2 = clone $query;
        $clone3 = clone $query;

        $transaction_today          = $clone1->whereDate('transaction.created_at', Carbon::today())->first();

        $transaction_yesterday      = $clone2->whereDate('transaction.created_at', Carbon::yesterday())->first();

        $transaction_last_7_days    = $clone3->whereDate('transaction.created_at','>',Carbon::today()->subDays(7))->first();

        $qty_percent                = number_format((($transaction_today->count-$transaction_yesterday->count)/$transaction_yesterday->count)*100,2, ',' , '.'). '%';
        
        $total_percent              = number_format((($transaction_today->price-$transaction_yesterday->price)/$transaction_yesterday->price)*100,2, ',' , '.'). '%';

        $user['today_transaction']['car_name']          = $transaction_today->car_name;
        $user['today_transaction']['qty']               = $transaction_today->count. ' ' .$qty_percent.'' ;
        $user['today_transaction']['total']             = 'Rp.' . number_format($transaction_today->price,0, ',' , '.') .' '.$total_percent; 

        $user['last_7_days']['car_name']          = $transaction_last_7_days->car_name;
        $user['last_7_days']['qty']               = $transaction_last_7_days->count;
        $user['last_7_days']['total']             = 'Rp.' . number_format($transaction_last_7_days->price,0, ',' , '.');
        if($user){
            return $this->responseApi('ok',$user,'User found');
        }else{
            return $this->responseApi('error','','Session not found!');
        }  
    }
}
