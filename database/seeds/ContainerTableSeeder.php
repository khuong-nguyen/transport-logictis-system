<?php
use Illuminate\Database\Seeder;

class ContainerTableSeeder extends Seeder {

    public function run()
    {
        DB::table('container')->insert([
            'container_code' => '20DC',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '40DC',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '45DC',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '20RF',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '40HC',
            'container_size' => null
        ]);
        
        DB::table('container')->insert([
            'container_code' => '40RF',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '20FL',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '40FL',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '20TK',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '40TK',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '20OT',
            'container_size' => null
        ]);
        DB::table('container')->insert([
            'container_code' => '40OT',
            'container_size' => null
        ]);
    }

}