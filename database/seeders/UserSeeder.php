<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'user_id'           => 'ADMIN',
            'email'             => 'admin@mail.com',
            'id_account_type'   => 'admin',
            'password'          => Hash::make('imtheadmin'),
            'status'            => 1,
        ]);
    }
}
