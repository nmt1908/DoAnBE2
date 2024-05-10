<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederBanner extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            'img_banner' => 'banner1.jpg',
            'name_banner' => 'Giảm giá Samsung',
            'description_banner' => 'Samsung đang có chương trình mua 2 được 5 tính tiền 7 =))',
            'status' => 1 
        ]);
        DB::table('banners')->insert([
            'img_banner' => 'banner2.jpg',
            'name_banner' => 'Đại hội FLASHSHIP',
            'description_banner' => 'Giao hàng nhanh chóng trong vòng 2 giờ , mua 7 tính tiền 3',
            'status' => 1 
        ]);
        DB::table('banners')->insert([
            'img_banner' => 'banner3.jpg',
            'name_banner' => 'Tưng bừng khai trương, ngập tràn khuyến mãi!',
            'description_banner' => 'Nhân dịp ngày khai trương, mua sản phẩm đắt nhất sẽ được tặng thẻ cào trị giá 20.000VND',
            'status' => 1 
        ]);
        DB::table('banners')->insert([
            'img_banner' => 'banner4.jpg',
            'name_banner' => 'Hỗ trợ mùa dịch, giá ưu đãi đến bất ngờ!',
            'description_banner' => 'Điện thoại được giảm hơn 30%, Đồng hồ điện tử được giảm 50%...',
            'status' => 1 
        ]);
        
    }
}
