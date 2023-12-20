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
}

