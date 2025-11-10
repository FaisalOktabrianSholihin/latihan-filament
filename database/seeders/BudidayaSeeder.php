<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Budidaya;

class BudidayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $budidayas = [
            [
                'id_budidaya' => 1,
                'id_asman_manager' => 'ASM001',
                'nm_asman_manager' => 'Ahmad Hidayat',
                'id_atasan' => '013',
            ],
            [
                'id_budidaya' => 2,
                'id_asman_manager' => 'ASM002',
                'nm_asman_manager' => 'Budi Santoso',
                'id_atasan' => '012',
            ],
            [
                'id_budidaya' => 3,
                'id_asman_manager' => 'MGR001',
                'nm_asman_manager' => 'Citra Dewi',
                'id_atasan' => '008',
            ],
            [
                'id_budidaya' => 4,
                'id_asman_manager' => 'MGR002',
                'nm_asman_manager' => 'Dedi Kurniawan',
                'id_atasan' => '009',
            ],
            [
                'id_budidaya' => 5,
                'id_asman_manager' => 'ASM003',
                'nm_asman_manager' => 'Eka Putra',
                'id_atasan' => '391',
            ],
        ];

        foreach ($budidayas as $budidaya) {
            Budidaya::create($budidaya);
        }
    }
}
