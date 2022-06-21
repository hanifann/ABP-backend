<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RecomendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recomendations')->insert([
            'title' => Str::random(10),
            'content' => Str::random(255),
            'author' => Str::random(12),
            'image' => 'images/wisata.jpg'
        ]);
    }
}
