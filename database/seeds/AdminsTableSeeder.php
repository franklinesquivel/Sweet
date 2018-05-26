<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'dui' => '00000000-0',
            'email' => 'frank.esquivel115@gmail.com',
            'password' => bcrypt('eg171989'),
            'name' => 'Franklin Armando',
            'lastname' => 'Esquivel Guevara',
            'birthdate' => '1998-09-26',
            'age' => 19,
            'address' => 'Sta. Lucía',
            'phone' => '76702869',
            'user_type_id' => 'ADM',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
