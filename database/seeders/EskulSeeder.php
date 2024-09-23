<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EskulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('eskuls')->insert([
            ['name' => 'Basketball'],
            ['name' => 'Football'],
            ['name' => 'Music Club'],
            ['name' => 'Art Club'],
            ['name' => 'Science Club'],
        ]);
    }
}
