<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルを使用
use App\Models\Sale; // Saleモデルを使用
use Illuminate\Support\Facades\DB; //try-catch構文で追加

class SaleController extends Controller
{
    public function purchase(Request $request) {

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $sale = new Sale;
            //Saleモデルのpublic function getPurchase()の値を取得する
            $sales = $sale->getPurchase($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // 処理結果のメッセージをjsonで表示させる。
        return $sales;
    }
}
