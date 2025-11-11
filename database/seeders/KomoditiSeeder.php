<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Komoditi;

class KomoditiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $komoditis = [
        //     [
        //         'id_komoditi' => 101,
        //         'nm_komoditi' => 'Padi',
        //         'ket_komoditi' => 'Komoditas padi sawah untuk pangan utama',
        //     ],
        //     [
        //         'id_komoditi' => 102,
        //         'nm_komoditi' => 'Jagung',
        //         'ket_komoditi' => 'Komoditas jagung untuk pakan ternak dan pangan',
        //     ],
        //     [
        //         'id_komoditi' => 103,
        //         'nm_komoditi' => 'Kedelai',
        //         'ket_komoditi' => 'Komoditas kedelai untuk bahan baku industri pangan',
        //     ],
        //     [
        //         'id_komoditi' => 104,
        //         'nm_komoditi' => 'Cabai',
        //         'ket_komoditi' => 'Komoditas cabai merah untuk bumbu dan industri',
        //     ],
        //     [
        //         'id_komoditi' => 105,
        //         'nm_komoditi' => 'Bawang Merah',
        //         'ket_komoditi' => 'Komoditas bawang merah untuk bumbu dapur',
        //     ],
        //     [
        //         'id_komoditi' => 106,
        //         'nm_komoditi' => 'Tomat',
        //         'ket_komoditi' => 'Komoditas tomat untuk sayuran dan industri',
        //     ],
        // ];

        // Ini dari database
        $komoditis = [
            [
                'id_komoditi' => 01,
                'nm_komoditi' => 'Edamame',
                'ket_komoditi' => 'Komoditas Edamame',
            ],
            [
                'id_komoditi' => 02,
                'nm_komoditi' => 'Okura',
                'ket_komoditi' => 'Komoditas Okura',
            ],
            [
                'id_komoditi' => 18,
                'nm_komoditi' => 'Chamame',
                'ket_komoditi' => 'Komoditas Chamame',
            ],
        ];

        foreach ($komoditis as $komoditi) {
            Komoditi::create($komoditi);
        }
    }
}
