<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; // ソート機能のためSortableパッケージ追加

class Product extends Model
{
    use HasFactory; // ダミーレコードを代入する機能を使う
    use Sortable; // Sortable機能追加

    //ソート対象指定：商品ID、商品名、価格、在庫数、メーカー
    public $sortable = [
        'id',
        'product_name',
        'company_id',
        'price',
        'stock',
    ];

    // 以下の情報（属性）を一度に保存したり変更したりできる設定
    // $fillable を設定しないと、Laravelはセキュリティリスクを避けるために、この一括代入をブロックする。
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
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
        // sortable() を宣言する（ソート処理のため追加）
        $query = Product::query()->sortable();
        // 指定したカラムから複数の値を重複せず取得する
        $companies = Company::groupBy('company_name')->get('company_name');
        // キーワードから検索処理  ※ $search → $search_wordに変更
        $search_word = $request->get('search');
        if ($search_word) {
        //$search_word に値がある場合、検索処理を実行
            $query->where('product_name', 'LIKE', "%{$search_word}%");
        }
        // メーカーから検索処理 ※ $select → $select_idに変更
        $select_id = $request->get('select');
        if ($select_id) {
            $query->where('company_id', $select_id);
        }
        // 価格（下限・上限）から検索処理
        $search_p_lower = $request->get('price_lower');
        if ($search_p_lower) {
            $query->where('price', '>=', $search_p_lower);
        }
        $search_p_upper = $request->get('price_upper');
        if ($search_p_upper) {
            $query->where('price', '<=', $search_p_upper);
        }
        // 在庫数（下限・上限）から検索処理
        $search_s_lower = $request->get('stock_lower');
        if ($search_s_lower) {
            $query->where('stock', '>=', $search_s_lower);
        }
        $search_s_upper = $request->get('stock_upper');
        if ($search_s_upper) {
            $query->where('stock', '<=', $search_s_upper);
        }

        $products = $query->get();
        return $products;
    }

    // ProductControllerのpublic function store(Request $request)の内容
    // 送られたデータをデータベースに保存する
    public function getStore($request) {

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

    // ProductControllerのpublic function update(Request $request, $id)の内容
    public function getUpdate($request, $id) {
        
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
