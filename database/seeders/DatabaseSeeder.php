<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1'),
        ]);

        // Seeder untuk Master Data
        $this->call([
            KomoditiSeeder::class,
            BudidayaSeeder::class,
            MstFasemonitorSeeder::class,
            KriteriaSeeder::class,

            // Seeder untuk Data Transaksi
            TcSeeder::class,
            MonitorTcSeeder::class,
        ]);
    }
}
