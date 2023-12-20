<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // ダミーレコードを代入する機能を使う

    // 以下の情報（属性）を一度に保存したり変更したりできる設定
    // $fillable を設定しないと、Laravelはセキュリティリスクを避けるために、この一括代入をブロックする。
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    // Productモデルがsalesテーブルとリレーション関係を結ぶためのメソッド
    public function sales() {
        return $this->hasMany(Sale::class);
    }

    // Productモデルがcompanysテーブルとリレーション関係を結ぶ為のメソッド
    public function company() {
        return $this->belongsTo(Company::class);
    }

    // ProductController の　public function index(Request $request)メソッドの内容
    public function getIndex($request) {
       // 指定したモデルに関連するテーブルから全てのレコードを取得する
       $query = Product::query();
       $companies = Company::groupBy('company_name')->get('company_name');
        // キーワードから検索処理
        $search = $request->input('search');
        if ($search) {
        //$search に値がある場合、検索処理を実行
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        $select = $request->input('select');
        if ($select) {
        //$select に値がある場合、検索処理を実行
            $query->where('company_id', $select);
        }
        $products = $query->get();
        return $products;
    }

    // ProductController の　public function store(Request $request)メソッドの内容
    // 送られたデータをデータベースに保存する
    public function getStore($request) {
        // リクエストを確認して、必要な情報が全て揃っているかチェック
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', // 未入力でもOK
            'img_path' => 'nullable|image|max:2048', // 未入力でもOK,画像ファイルであること,サイズ2048KB(2MB)まで
        ]);
        //バリデーションによりフォームに未入力項目があればエラーメッセー発生させる（未入力です　など）

        // リクエストから情報を取得し新しく商品情報を作成する
        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);
        //new Product([]) によって新しい「Product」（レコード）を作成
        //new で新しいインスタンスを作成

        // リクエストに画像が含まれている場合、画像を保存する。
        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->getClientOriginalName();
            $file_path = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/'. $file_path;
        }

        // 作成したデータベースに新しいレコードとして保存する。
        $product->save();
    }

    // ProductController の　public function update(Request $request, $id)メソッドの内容
    public function getUpdate($request, $id) {
         // リクエストを確認し必要な情報が全て揃っているかチェック
         $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', // 未入力でもOK
            'img_path' => 'nullable|image|max:2048', // 未入力でもOK,画像ファイルであること,サイズ2048KB(2MB)まで
        ]);
        //バリデーションによりフォームに未入力項目があればエラーメッセー発生させる（未入力です　など）
        
        // テーブルを指定し、idで商品を検索する。
        $product = Product::find($id); 

        // 商品情報を更新
        //productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        // img_pathがある場合の更新
        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->getClientOriginalName();
            $file_path = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/'. $file_path;
        }
        // モデルインスタンスである$productに対して行われた変更をデータベースに保存する
        $product->save();
    }
}
