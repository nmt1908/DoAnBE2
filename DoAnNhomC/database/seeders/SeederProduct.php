<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederProduct extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'product_name' => 'Iphone 15 ProMax 1TB Natural',
            'price' => 1200.00,
            'description' => 'Sản phẩm mới ra mắt của hãng Apple, với thiết kế sang trọng quý phái phù hợp với người có tiền nhiều...',
            'quantity' => 10 ,
            'is_featured' => 1 ,
            'category_id' => 1 ,
            'brand_id' => 5 ,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'product_name' => 'Samsung Galaxy Note 10',
            'price' => 1100.00,
            'description' => 'Sản phẩm mới ra mắt của hãng Samsung, với thiết kế mới kèm bút thông minh...',
            'quantity' => 10 ,
            'is_featured' => 1 ,
            'category_id' => 1 ,
            'brand_id' => 3 ,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'product_name' => 'Oppo A58',
            'price' => 940.00,
            'description' => 'Sản phẩm mới ra mắt của hãng Oppo, với thiết kế camera mới chụp hình siêu nét...',
            'quantity' => 10 ,
            'is_featured' => 1 ,
            'category_id' => 1 ,
            'brand_id' => 4 ,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'product_name' => 'TV LG UHD 4K ',
            'price' => 3200.00,
            'description' => 'Sản phẩm mới ra mắt của hãng LG, với kích thước 55inch độ phân giải 4K, xem CR7 đá banh thì hết nói...',
            'quantity' => 10 ,
            'is_featured' => 1 ,
            'category_id' => 4 ,
            'brand_id' => 6 ,
            'status' => 1,
        ]);
    }
}
