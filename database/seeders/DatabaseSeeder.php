<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Warehouse::create([
            'w_code' => 'HQT',
            'w_name' => 'HEADQUARTER',
            'address' => 'Bandung, Jawa Barat, ID, 40375',
            'chart_of_account_id' => 1
        ]);

        \App\Models\User::factory()->create([
            'name' => 'administrator',
            'email' => 'administrator@jour-mail.com',
            'password' => bcrypt(88888888),
            'role' => 'Staff',
            'registered_at' => time(),
            'last_login' => time(),
            'status' => 1,
            'warehouse_id' => 1
        ]);

        \App\Models\User::factory()->create([
            'name' => 'fend',
            'email' => 'fendnugraha92@gmail.com',
            'password' => bcrypt(88888888),
            'role' => 'Administrator',
            'registered_at' => time(),
            'last_login' => time(),
            'status' => 1,
            'warehouse_id' => 1
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
