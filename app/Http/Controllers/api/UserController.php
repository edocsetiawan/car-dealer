<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TraitApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

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
        if($user){
            return $this->responseApi('ok',$user,'User found');
        }else{
            return $this->responseApi('error','','Session not found!');
        }  
    }
}
