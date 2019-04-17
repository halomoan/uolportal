<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'IT & SAPCC'
        ]);

        DB::table('departments')->insert([
            'name' => 'HRD'
        ]);

        DB::table('departments')->insert([
            'name' => 'FINANCE'
        ]);
    }
}
