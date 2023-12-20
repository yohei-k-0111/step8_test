<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Company;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array {
        return [
                'company_id' => Company::factory(),
                'product_name' => $this->faker->randomElement(['コーラ', 'サイダー', 'ファン太', '午前の紅茶', 'ライフカード',
                'デッカビタ', 'ヤバリースオレンジ', 'りんごジュース', 'ジャスミン茶', 'ウーロン茶', 'ミネラルウォーター']),
                // 指定した中からランダムでダミー商品名
                'price' => $this->faker->randomElement([400, 350, 280, 200, 180, 150, 120, 100]),
                // 指定した中からランダムでダミー価格
                'stock' => $this->faker->numberBetween(0, 20),  // 0から20のランダムな数字でダミーの在庫数
                'comment' => $this->faker->sentence,  // ダミーの説明文
                'img_path' => 'https://picsum.photos/200/300',  // 200x300のランダムな画像
        ];
    }
}
