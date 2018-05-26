<?php

use Illuminate\Database\Seeder;

class UsersTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_types')->insert([
            'id' => 'ADM',
            'name' => 'Administrador',
            'description' => 'Administrador de la plataforma.'
        ]);

        DB::table('users_types')->insert([
            'id' => 'CLE',
            'name' => 'Cliente',
            'description' => 'Cliente de la plataforma'
        ]);
    }
}
