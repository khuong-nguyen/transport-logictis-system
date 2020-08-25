<?php
use Illuminate\Database\Seeder;

class LocationCodeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('location_code')->insert([
            'seq' => '798',
            'node_code' => 'VNVUNM6',
            'node_name' => 'TAN CANG CAI MEP THI VAI TERMINAL (TCTT)'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '800',
            'node_code' => 'VNVUNM5',
            'node_name' => 'CAI MEP INTERNATIONAL TERMINAL (CMIT)'
        ]);
        DB::table('location_code')->insert([
            'seq' => '801',
            'node_code' => 'VNVUNM4',
            'node_name' => 'TAN CANG - CAI MEP INTERNATIONAL TERMINAL (TCIT)'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '799',
            'node_code' => 'VNVUNM3',
            'node_name' => 'SAIGON INTERNATIONAL TERMINALS VIETNAM'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '802',
            'node_code' => 'VNVUNM2',
            'node_name' => 'CSP-PSA INTERNATIONAL PORT'
        ]);
        DB::table('location_code')->insert([
            'seq' => '803',
            'node_code' => 'VNVUNM1',
            'node_name' => 'TANCANG - CAIMEP CONTAINER TERMINAL (TCCT)'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '797',
            'node_code' => 'VNVCACT',
            'node_name' => 'CAN THO PORT'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '786',
            'node_code' => 'VNUIHY3',
            'node_name' => 'TAN CANG MIEN TRUNG TERMINAL'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '787',
            'node_code' => 'VNUIHY2',
            'node_name' => 'INSERCO'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '788',
            'node_code' => 'VNUIHY1',
            'node_name' => 'QUI NHON TMNL'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '770',
            'node_code' => 'VNSGNYT',
            'node_name' => 'TBS WAREHOUSE'
        ]);
        
        DB::table('location_code')->insert([
            'seq' => '757',
            'node_code' => 'VNSGNYS',
            'node_name' => 'ICD SOTRANS'
        ]);
    }

}