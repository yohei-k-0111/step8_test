<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用

class SaleController extends Controller
{
    public function purchase(Request $request) {

        $sale = new Sale;
        //Saleモデルのpublic function getPurchase()の値を取得する
        $sales = $sale->getPurchase($request);

        // 処理結果のメッセージをjsonで表示させる。
        return $sales;
    }
}
