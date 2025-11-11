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
        // $budidayas = [
        //     [
        //         'id_budidaya' => 1,
        //         'id_asman_manager' => 'ASM001',
        //         'nm_asman_manager' => 'Ahmad Hidayat',
        //         'id_atasan' => '013',
        //     ],
        //     [
        //         'id_budidaya' => 2,
        //         'id_asman_manager' => 'ASM002',
        //         'nm_asman_manager' => 'Budi Santoso',
        //         'id_atasan' => '012',
        //     ],
        //     [
        //         'id_budidaya' => 3,
        //         'id_asman_manager' => 'MGR001',
        //         'nm_asman_manager' => 'Citra Dewi',
        //         'id_atasan' => '008',
        //     ],
        //     [
        //         'id_budidaya' => 4,
        //         'id_asman_manager' => 'MGR002',
        //         'nm_asman_manager' => 'Dedi Kurniawan',
        //         'id_atasan' => '009',
        //     ],
        //     [
        //         'id_budidaya' => 5,
        //         'id_asman_manager' => 'ASM003',
        //         'nm_asman_manager' => 'Eka Putra',
        //         'id_atasan' => '391',
        //     ],
        // ];

        // dari database asli
        $budidayas = [
            [
                'id_budidaya' => 1,
                'id_asman_manager' => '013',
                'nm_asman_manager' => 'DODI W',
                'id_atasan' => null, // Mengganti NULL dari SQL
            ],
            [
                'id_budidaya' => 2,
                'id_asman_manager' => '012',
                'nm_asman_manager' => 'SUTIKNO A',
                'id_atasan' => null, // Mengganti NULL dari SQL
            ],
            [
                'id_budidaya' => 3,
                'id_asman_manager' => '008',
                'nm_asman_manager' => 'M. NURHADI',
                'id_atasan' => null, // Mengganti NULL dari SQL
            ],
            [
                'id_budidaya' => 4,
                'id_asman_manager' => '009',
                'nm_asman_manager' => 'WIDO S',
                'id_atasan' => null, // Mengganti NULL dari SQL
            ],
            [
                'id_budidaya' => 5,
                'id_asman_manager' => '391',
                'nm_asman_manager' => 'NANANG PRIWAHYUDI',
                'id_atasan' => '013',
            ],
            [
                'id_budidaya' => 6,
                'id_asman_manager' => '307',
                'nm_asman_manager' => 'ABDUL HAMID',
                'id_atasan' => '008',
            ],
            [
                'id_budidaya' => 7,
                'id_asman_manager' => '023',
                'nm_asman_manager' => 'DEDY WAHYUDI',
                'id_atasan' => '013',
            ],
            [
                'id_budidaya' => 8,
                'id_asman_manager' => '354',
                'nm_asman_manager' => 'GALIH JALUTAMA',
                'id_atasan' => '013',
            ],
            [
                'id_budidaya' => 9,
                'id_asman_manager' => '714',
                'nm_asman_manager' => 'YULIATNO',
                'id_atasan' => '013',
            ],
        ];

        foreach ($budidayas as $budidaya) {
            Budidaya::create($budidaya);
        }
    }
}
