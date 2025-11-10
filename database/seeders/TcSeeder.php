<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tc;
use Carbon\Carbon;

class TcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tcs = [
            [
                'id_tc' => 1,
                'tracecode' => 'TC-2025-001',
                'id_komoditi' => 101, // Padi
                'id_budidaya' => 1, // Ahmad Hidayat
                'tgl_tanam' => Carbon::parse('2025-01-15'),
                'luas_tanam' => '2.5',
                'tdk_tc' => 'TDK-001',
                'wilayah_tc' => 'Blok A, Desa Sukamaju',
            ],
            [
                'id_tc' => 2,
                'tracecode' => 'TC-2025-002',
                'id_komoditi' => 102, // Jagung
                'id_budidaya' => 2, // Budi Santoso
                'tgl_tanam' => Carbon::parse('2025-02-01'),
                'luas_tanam' => '3.0',
                'tdk_tc' => 'TDK-002',
                'wilayah_tc' => 'Blok B, Desa Makmur',
            ],
            [
                'id_tc' => 3,
                'tracecode' => 'TC-2025-003',
                'id_komoditi' => 103, // Kedelai
                'id_budidaya' => 3, // Citra Dewi
                'tgl_tanam' => Carbon::parse('2025-02-10'),
                'luas_tanam' => '1.5',
                'tdk_tc' => 'TDK-003',
                'wilayah_tc' => 'Blok C, Desa Sentosa',
            ],
            [
                'id_tc' => 4,
                'tracecode' => 'TC-2025-004',
                'id_komoditi' => 104, // Cabai
                'id_budidaya' => 4, // Dedi Kurniawan
                'tgl_tanam' => Carbon::parse('2025-03-05'),
                'luas_tanam' => '1.0',
                'tdk_tc' => 'TDK-004',
                'wilayah_tc' => 'Blok D, Desa Sejahtera',
            ],
            [
                'id_tc' => 5,
                'tracecode' => 'TC-2025-005',
                'id_komoditi' => 105, // Bawang Merah
                'id_budidaya' => 5, // Eka Putra
                'tgl_tanam' => Carbon::parse('2025-03-20'),
                'luas_tanam' => '0.8',
                'tdk_tc' => 'TDK-005',
                'wilayah_tc' => 'Blok E, Desa Maju',
            ],
            [
                'id_tc' => 6,
                'tracecode' => 'TC-2025-006',
                'id_komoditi' => 106, // Tomat
                'id_budidaya' => 1, // Ahmad Hidayat
                'tgl_tanam' => Carbon::parse('2025-04-01'),
                'luas_tanam' => '1.2',
                'tdk_tc' => 'TDK-006',
                'wilayah_tc' => 'Blok F, Desa Sukamaju',
            ],
            [
                'id_tc' => 7,
                'tracecode' => 'TC-2025-007',
                'id_komoditi' => 101, // Padi
                'id_budidaya' => 2, // Budi Santoso
                'tgl_tanam' => Carbon::parse('2025-04-15'),
                'luas_tanam' => '3.5',
                'tdk_tc' => 'TDK-007',
                'wilayah_tc' => 'Blok G, Desa Makmur',
            ],
            [
                'id_tc' => 8,
                'tracecode' => 'TC-2025-008',
                'id_komoditi' => 102, // Jagung
                'id_budidaya' => 3, // Citra Dewi
                'tgl_tanam' => Carbon::parse('2025-05-01'),
                'luas_tanam' => '2.8',
                'tdk_tc' => 'TDK-008',
                'wilayah_tc' => 'Blok H, Desa Sentosa',
            ],
        ];

        foreach ($tcs as $tc) {
            Tc::create($tc);
        }
    }
}
