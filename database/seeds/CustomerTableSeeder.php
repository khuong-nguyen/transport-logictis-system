<?php
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder {

    public function run()
    {
        DB::table('customer')->insert([
            'customer_legal_english_name' => 'My Friend Co.',
            'customer_language_name' => 'Ban Toi',
            'customer_address' => '74/4 Tran Hung Dao P2, Q5',
            'customer_code' => 'VN1',
            'fax' => '0288388733',
            'tel' => '0809939887',
            'tax_code' => '000303303030',
            'country_code' => 'VN',
            'city' => 'SG',
            'location_code' => 'VNSG',
            'zip_code' => '028',
            'post_office_box' => 'BOX00001',
            'sale_office_code' => 'SALEOFF0001',
            'sale_rep_code' => 'SALEREP0002',
            'customer_type' => '01',
        ]);
    }

}