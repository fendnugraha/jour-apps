<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Contact;
use App\Models\Setting;
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
        $this->call([
            AccountSeeder::class,
            ChartOfAccountSeeder::class
        ]);

        Warehouse::create([
            'w_code' => 'HQT',
            'w_name' => 'HEADQUARTER',
            'address' => 'Bandung, Jawa Barat, ID, 40375',
            'chart_of_account_id' => 1
        ]);

        User::factory()->create([
            'name' => 'administrator',
            'email' => 'administrator@jour-mail.com',
            'password' => bcrypt(88888888),
            'role' => 'Staff',
            'registered_at' => time(),
            'last_login' => time(),
            'status' => 1,
            'warehouse_id' => 1
        ]);

        User::factory()->create([
            'name' => 'fend',
            'email' => 'fendnugraha92@gmail.com',
            'password' => bcrypt(88888888),
            'role' => 'Administrator',
            'registered_at' => time(),
            'last_login' => time(),
            'status' => 1,
            'warehouse_id' => 1
        ]);

        Contact::factory()->count(50)->create();

        Setting::create([
            'app_name' => 'Jour Apps',
            'address' => 'Jl. Pahlawan No. 1',
            'telephone' => '08123456789',
            'email' => 'admin@jour.com',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'description' => 'Jour Apps',
            'periode' => date('Y'),
            'deposit_account' => '20100-002',
            'modal_account' => '30100-001',
            'profit_loss_account' => '30100-002',
        ]);
        // AccountTrace::factory(20)->create();

        // \App\Models\User::factory(10)->create();
    }
}
