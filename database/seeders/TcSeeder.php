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
                'tracecode' => '25C.307.18.A-0020',
                'id_komoditi' => 18, // Chamame
                'id_budidaya' => 6, // ABDUL HAMID
                'tgl_tanam' => Carbon::parse('2025-10-14'),
                'luas_tanam' => '6.3',
                'tdk_tc' => '10C',
                'wilayah_tc' => 'Jember',
            ],
            [
                'id_tc' => 2,
                'tracecode' => '25C.023.01.A-0021',
                'id_komoditi' => 1, // Edamamae
                'id_budidaya' => 7, // DEDY WAHYUDI
                'tgl_tanam' => Carbon::parse('2025-10-13'),
                'luas_tanam' => '3.6',
                'tdk_tc' => '10C',
                'wilayah_tc' => 'Jember',
            ],
            [
                'id_tc' => 3,
                'tracecode' => '25C.391.01.A-0022',
                'id_komoditi' => 1, // Edamame
                'id_budidaya' => 5, // NANANG PRIWAHYUDI
                'tgl_tanam' => Carbon::parse('2025-10-16'),
                'luas_tanam' => '0.8',
                'tdk_tc' => '10C',
                'wilayah_tc' => 'Jember',
            ],
            [
                'id_tc' => 4,
                'tracecode' => '25C.391.18.A-0023',
                'id_komoditi' => 18, // Chamame
                'id_budidaya' => 5, // NANANG PRIWAHYUDI
                'tgl_tanam' => Carbon::parse('2025-10-17'),
                'luas_tanam' => '4.3',
                'tdk_tc' => '10C',
                'wilayah_tc' => 'Jember',
            ],
            [
                'id_tc' => 5,
                'tracecode' => '25C.354.18.A-0024',
                'id_komoditi' => 18, // Chamame
                'id_budidaya' => 8, // GALIH JALUTAMA
                'tgl_tanam' => Carbon::parse('2025-11-02'),
                'luas_tanam' => '5.0',
                'tdk_tc' => '11A',
                'wilayah_tc' => 'Lumajang',
            ],
        ];

        foreach ($tcs as $tc) {
            Tc::create($tc);
        }
    }
}
