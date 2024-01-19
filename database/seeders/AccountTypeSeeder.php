<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Organization',
            'Individual',
            'Client',
        ];

        foreach ($values as $value) {
            DB::table('account_type')->insert([
                'account_type_name' => $value,
            ]);
        }
    }
}
