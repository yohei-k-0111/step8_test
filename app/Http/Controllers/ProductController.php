<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Requestクラスはブラウザに表示させるフォームから送信されたデータをコントローラのメソッドで引数として受け取る。
use App\Models\Product; // Productモデルをこのファイルで使用する。
use App\Models\Company; // Companyモデルをこのファイルで使用する。

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $product = new Product;
        $products = $product->getIndex($request);
        $companies = Company::all();
        return view('products.index', compact('companies', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // 全ての会社の情報を取得する。
        $companies = Company::all();
        // 商品作成画面を表示し、取得した全ての会社情報を渡す。
        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 送られたデータをデータベースに保存するメソッド
    public function store(Request $request) {
        $product = new Product;
        $products = $product->getStore($request);
        // 処理後に商品一覧画面にリダイレクトする。
        $companies = Company::all();
        return redirect()->route('products.create', compact('companies'))->with('crt_message',
         '商品情報が登録されました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // (Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てる。
    public function show($id) {
        // テーブルを指定しidで商品を検索する。
        $product = Product::find($id);
        // 商品詳細画面を表示し、商品の詳細情報を画面に渡す。
        return view('products.show', ['product' => $product]);
    //　viewへproduct変数が使えるように値を渡す
    // ['product' => $product]で、viewでproductを使えるようにする
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // テーブルを指定し、idで商品を検索する。
        $product = Product::find($id); 
        // 全ての会社の情報を取得する。
        $companies = Company::all();

        // 商品編集画面を表示し商品情報と会社情報を画面に渡す。
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $product = new Product;
        $products = $product->getUpdate($request, $id);

        // 処理後、商品一覧画面にリダイレクトする。
        $product = Product::find($id); 
        $companies = Company::all();
        return redirect()->route('products.edit', compact('product', 'companies'))->with('edt_message',
         '商品情報が更新されました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //(Product $product) 指定されたIDで商品をデータベースから検索し、その結果を $product に割り当てる。
    public function destroy($id) {
        // テーブルを指定し、idで商品を検索する。
        $product = Product::find($id);
        // 商品削除
        $product->delete();

        // 処理後、商品一覧画面に戻る。
        return redirect('/products')->with('dlt_message', '商品情報が削除されました');
        //URLの/productsにリダイレクト
    }
}
