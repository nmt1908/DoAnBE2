<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Điện thoại',
            'slug' => 'dien-thoai',
            'image' => 'phone.jpg',
            'status' => 1 
        ]);
        DB::table('categories')->insert([
            'name' => 'Laptop',
            'slug' => 'lap-top',
            'image' => 'laptop.jpg',
            'status' => 1 
        ]);
        DB::table('categories')->insert([
            'name' => 'Tablet',
            'slug' => 'tab-let',
            'image' => 'tablet.jpg',
            'status' => 1 
        ]);
        DB::table('categories')->insert([
            'name' => 'Tivi',
            'slug' => 'ti-vi',
            'image' => 'tivi.jpg',
            'status' => 1 
        ]);
    }
}
