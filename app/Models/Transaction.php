<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table    = 'transaction';
    protected $fillable = ['buyer_name','buyer_email','buyer_phone_number','car_id','qty','total_price'];
}
