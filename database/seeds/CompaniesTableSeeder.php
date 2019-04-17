<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'bukrs' => '2000',
            'name' => 'PARKROYAL On Beach Road'
        ]);

        DB::table('companies')->insert([
            'bukrs' => '2001',
            'name' => 'PARKROYAL On Kitchener'
        ]);

        DB::table('companies')->insert([
            'bukrs' => '1000',
            'name' => 'UOL Group Limited'
        ]);

    }
}
