<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // テーブルのリセット
        DB::table('users')->delete();

        // 日本語化の設定
        $faker = Factory::create('ja_JP');

        // ダミーデータ20件挿入（ファクトリ）
        for ($i = 0; $i < 20; $i ++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => Hash::make('123456Aa'),
            ]);
        }
    }
}
