<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'product_id' => \App\Models\Product::factory(), // Productモデルのファクトリーを利用
            // 'created_at' と 'updated_at' はEloquentが自動的に処理する。
        ];
    }
}
