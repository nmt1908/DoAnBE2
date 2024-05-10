<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederBrand extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            'name' => 'Samsung',
            'slug' => 'sam-sung',
            'image' => 'samsung.jpg',
            'status' => 1 
        ]);
        DB::table('brands')->insert([
            'name' => 'Oppo',
            'slug' => 'op-po',
            'image' => 'oppo.png',
            'status' => 1 
        ]);
        DB::table('brands')->insert([
            'name' => 'Apple',
            'slug' => 'app-le',
            'image' => 'apple.png',
            'status' => 1 
        ]);
        DB::table('brands')->insert([
            'name' => 'LG',
            'slug' => 'l-g',
            'image' => 'lg.png',
            'status' => 1 
        ]);
    }
}
