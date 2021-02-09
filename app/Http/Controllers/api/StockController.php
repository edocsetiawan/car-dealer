<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;
use App\Http\Controllers\Api\TraitApi;

class StockController extends Controller
{
    use TraitApi;

    /**
     * insert new stock data
     */

     public function addNewStock(Request $request)
     {
        $data = $request->all();

        $stock['car_name'] = $data['car_name'];
        $stock['price']    = $data['price'];
        $stock['stock']    = $data['stock'];

        Stock::create($stock);

        return $this->responseApi('ok','','New stock success insert');
     }

     /**
      * get stock
      */
      public function getStock()
      {
         $data = Stock::where('stock','>',0)->get();
         return $this->responseApi('ok',$data,'Data found');
      }
}
