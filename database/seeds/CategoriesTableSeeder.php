<?php

use Illuminate\Database\Seeder;
use Sweet\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Pastel',
            'description' => ''
        ]);

        DB::table('categories')->insert([
            'name' => 'Cupcake',
            'description' => ''
        ]);

        DB::table('categories')->insert([
            'name' => 'Muffin',
            'description' => ''
        ]);
    }
}
