<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            // Kriteria untuk Pembersihan Lahan (id_monitor = 1)
            ['id_kriteria' => 1, 'id_monitor' => 1, 'nm_kriteria' => 'Lahan bebas gulma', 'nilai_kriteria' => 30],
            ['id_kriteria' => 2, 'id_monitor' => 1, 'nm_kriteria' => 'Tidak ada sisa tanaman', 'nilai_kriteria' => 40],
            ['id_kriteria' => 3, 'id_monitor' => 1, 'nm_kriteria' => 'Drainase baik', 'nilai_kriteria' => 30],

            // Kriteria untuk Pengolahan Tanah (id_monitor = 2)
            ['id_kriteria' => 4, 'id_monitor' => 2, 'nm_kriteria' => 'Tanah gembur', 'nilai_kriteria' => 40],
            ['id_kriteria' => 5, 'id_monitor' => 2, 'nm_kriteria' => 'Permukaan rata', 'nilai_kriteria' => 30],
            ['id_kriteria' => 6, 'id_monitor' => 2, 'nm_kriteria' => 'pH tanah optimal', 'nilai_kriteria' => 30],

            // Kriteria untuk Pemilihan Benih (id_monitor = 3)
            ['id_kriteria' => 7, 'id_monitor' => 3, 'nm_kriteria' => 'Daya kecambah tinggi', 'nilai_kriteria' => 40],
            ['id_kriteria' => 8, 'id_monitor' => 3, 'nm_kriteria' => 'Benih bersertifikat', 'nilai_kriteria' => 35],
            ['id_kriteria' => 9, 'id_monitor' => 3, 'nm_kriteria' => 'Kemurnian tinggi', 'nilai_kriteria' => 25],

            // Kriteria untuk Jarak Tanam (id_monitor = 4)
            ['id_kriteria' => 10, 'id_monitor' => 4, 'nm_kriteria' => 'Jarak sesuai standar', 'nilai_kriteria' => 50],
            ['id_kriteria' => 11, 'id_monitor' => 4, 'nm_kriteria' => 'Kedalaman tanam tepat', 'nilai_kriteria' => 50],

            // Kriteria untuk Penyiraman (id_monitor = 5)
            ['id_kriteria' => 12, 'id_monitor' => 5, 'nm_kriteria' => 'Kelembaban optimal', 'nilai_kriteria' => 40],
            ['id_kriteria' => 13, 'id_monitor' => 5, 'nm_kriteria' => 'Frekuensi penyiraman tepat', 'nilai_kriteria' => 35],
            ['id_kriteria' => 14, 'id_monitor' => 5, 'nm_kriteria' => 'Sistem irigasi baik', 'nilai_kriteria' => 25],

            // Kriteria untuk Pemupukan (id_monitor = 6)
            ['id_kriteria' => 15, 'id_monitor' => 6, 'nm_kriteria' => 'Dosis pupuk sesuai', 'nilai_kriteria' => 35],
            ['id_kriteria' => 16, 'id_monitor' => 6, 'nm_kriteria' => 'Waktu pemupukan tepat', 'nilai_kriteria' => 35],
            ['id_kriteria' => 17, 'id_monitor' => 6, 'nm_kriteria' => 'Cara aplikasi benar', 'nilai_kriteria' => 30],

            // Kriteria untuk Hama dan Penyakit (id_monitor = 7)
            ['id_kriteria' => 18, 'id_monitor' => 7, 'nm_kriteria' => 'Tidak ada serangan hama', 'nilai_kriteria' => 35],
            ['id_kriteria' => 19, 'id_monitor' => 7, 'nm_kriteria' => 'Tanaman sehat', 'nilai_kriteria' => 40],
            ['id_kriteria' => 20, 'id_monitor' => 7, 'nm_kriteria' => 'Pengendalian efektif', 'nilai_kriteria' => 25],

            // Kriteria untuk Waktu Panen (id_monitor = 8)
            ['id_kriteria' => 21, 'id_monitor' => 8, 'nm_kriteria' => 'Umur panen tepat', 'nilai_kriteria' => 40],
            ['id_kriteria' => 22, 'id_monitor' => 8, 'nm_kriteria' => 'Kualitas hasil baik', 'nilai_kriteria' => 35],
            ['id_kriteria' => 23, 'id_monitor' => 8, 'nm_kriteria' => 'Cara panen benar', 'nilai_kriteria' => 25],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
