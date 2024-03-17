<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory; // ダミーレコードを代入する機能を使う

    public function product() {
        // Productモデルに属するリレーション「Product：Sale = 1：多」
        return $this->belongsTo(Product::class);
    }

    // $fillable属性を配列で追記 以下のフィールドを一度に保存や変更できる設定
    protected $fillable = [
        'product_id',
        'quantity',
    ];

    public function getPurchase($request) {

        // リクエストから必要なデータを取得する
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // 購入数 第２引数はデフォ値指定（nullの場合は1を代入）

        // データベースから対象の商品を検索・取得
        $product = Product::find($product_id);
        // productモデルを通してproductsテーブルから該当する"product_id"の情報を取得する

        // バリデーション処理をメッセージ表示する（商品が存在しない場合、在庫不足の場合）
        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
        if ($product->stock < $quantity) {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }

        // 在庫を減少させて保存する
        $product->stock -= $quantity; // 在庫数（$product->stock）から購入数（$quantity）を減算
        $product->save();

        // Salesテーブルに商品idと購入数を記録して保存する
        $sale = new Sale([
            'product_id' => $product_id,
            'quantity' => $quantity,
        ]); // 主キーであるid , created_at , updated_atは自動入力されるため不要
        $sale->save();

        // 処理完了のメッセージをjsonで表示させる。
        return response()->json(['message' => '購入成功']);
    }
}
