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
        // $kriterias = [
        //     // Kriteria untuk Pembersihan Lahan (id_monitor = 1)
        //     ['id_kriteria' => 1, 'id_monitor' => 1, 'nm_kriteria' => 'Lahan bebas gulma', 'nilai_kriteria' => 30],
        //     ['id_kriteria' => 2, 'id_monitor' => 1, 'nm_kriteria' => 'Tidak ada sisa tanaman', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 3, 'id_monitor' => 1, 'nm_kriteria' => 'Drainase baik', 'nilai_kriteria' => 30],

        //     // Kriteria untuk Pengolahan Tanah (id_monitor = 2)
        //     ['id_kriteria' => 4, 'id_monitor' => 2, 'nm_kriteria' => 'Tanah gembur', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 5, 'id_monitor' => 2, 'nm_kriteria' => 'Permukaan rata', 'nilai_kriteria' => 30],
        //     ['id_kriteria' => 6, 'id_monitor' => 2, 'nm_kriteria' => 'pH tanah optimal', 'nilai_kriteria' => 30],

        //     // Kriteria untuk Pemilihan Benih (id_monitor = 3)
        //     ['id_kriteria' => 7, 'id_monitor' => 3, 'nm_kriteria' => 'Daya kecambah tinggi', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 8, 'id_monitor' => 3, 'nm_kriteria' => 'Benih bersertifikat', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 9, 'id_monitor' => 3, 'nm_kriteria' => 'Kemurnian tinggi', 'nilai_kriteria' => 25],

        //     // Kriteria untuk Jarak Tanam (id_monitor = 4)
        //     ['id_kriteria' => 10, 'id_monitor' => 4, 'nm_kriteria' => 'Jarak sesuai standar', 'nilai_kriteria' => 50],
        //     ['id_kriteria' => 11, 'id_monitor' => 4, 'nm_kriteria' => 'Kedalaman tanam tepat', 'nilai_kriteria' => 50],

        //     // Kriteria untuk Penyiraman (id_monitor = 5)
        //     ['id_kriteria' => 12, 'id_monitor' => 5, 'nm_kriteria' => 'Kelembaban optimal', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 13, 'id_monitor' => 5, 'nm_kriteria' => 'Frekuensi penyiraman tepat', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 14, 'id_monitor' => 5, 'nm_kriteria' => 'Sistem irigasi baik', 'nilai_kriteria' => 25],

        //     // Kriteria untuk Pemupukan (id_monitor = 6)
        //     ['id_kriteria' => 15, 'id_monitor' => 6, 'nm_kriteria' => 'Dosis pupuk sesuai', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 16, 'id_monitor' => 6, 'nm_kriteria' => 'Waktu pemupukan tepat', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 17, 'id_monitor' => 6, 'nm_kriteria' => 'Cara aplikasi benar', 'nilai_kriteria' => 30],

        //     // Kriteria untuk Hama dan Penyakit (id_monitor = 7)
        //     ['id_kriteria' => 18, 'id_monitor' => 7, 'nm_kriteria' => 'Tidak ada serangan hama', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 19, 'id_monitor' => 7, 'nm_kriteria' => 'Tanaman sehat', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 20, 'id_monitor' => 7, 'nm_kriteria' => 'Pengendalian efektif', 'nilai_kriteria' => 25],

        //     // Kriteria untuk Waktu Panen (id_monitor = 8)
        //     ['id_kriteria' => 21, 'id_monitor' => 8, 'nm_kriteria' => 'Umur panen tepat', 'nilai_kriteria' => 40],
        //     ['id_kriteria' => 22, 'id_monitor' => 8, 'nm_kriteria' => 'Kualitas hasil baik', 'nilai_kriteria' => 35],
        //     ['id_kriteria' => 23, 'id_monitor' => 8, 'nm_kriteria' => 'Cara panen benar', 'nilai_kriteria' => 25],
        // ];


        $kriterias = [
            // id_monitor = 1: Realiasi Biaya Mingguan
            ['id_kriteria' => 1, 'id_monitor' => 1, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 2, 'id_monitor' => 1, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 3, 'id_monitor' => 1, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 2: Realiasi Biaya Mingguan
            ['id_kriteria' => 4, 'id_monitor' => 2, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 5, 'id_monitor' => 2, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 6, 'id_monitor' => 2, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 3: Realiasi Biaya Mingguan
            ['id_kriteria' => 7, 'id_monitor' => 3, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 8, 'id_monitor' => 3, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 9, 'id_monitor' => 3, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 4: Realiasi Biaya Mingguan
            ['id_kriteria' => 10, 'id_monitor' => 4, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 11, 'id_monitor' => 4, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 12, 'id_monitor' => 4, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 5: Realiasi Biaya Mingguan
            ['id_kriteria' => 13, 'id_monitor' => 5, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 14, 'id_monitor' => 5, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 15, 'id_monitor' => 5, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 6: Realiasi Biaya Mingguan
            ['id_kriteria' => 16, 'id_monitor' => 6, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 17, 'id_monitor' => 6, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 18, 'id_monitor' => 6, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 7: Realiasi Biaya Mingguan
            ['id_kriteria' => 19, 'id_monitor' => 7, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 20, 'id_monitor' => 7, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 21, 'id_monitor' => 7, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 8: Realiasi Biaya Mingguan
            ['id_kriteria' => 22, 'id_monitor' => 8, 'nm_kriteria' => 'A: <100%', 'nilai_kriteria' => 90],
            ['id_kriteria' => 23, 'id_monitor' => 8, 'nm_kriteria' => 'B: 100-102', 'nilai_kriteria' => 70],
            ['id_kriteria' => 24, 'id_monitor' => 8, 'nm_kriteria' => 'C: >102%', 'nilai_kriteria' => 50],

            // id_monitor = 9: Realiasi Biaya Mingguan
            ['id_kriteria' => 25, 'id_monitor' => 9, 'nm_kriteria' => '-', 'nilai_kriteria' => 100],
            ['id_kriteria' => 26, 'id_monitor' => 9, 'nm_kriteria' => '-', 'nilai_kriteria' => 100],
            ['id_kriteria' => 27, 'id_monitor' => 9, 'nm_kriteria' => '-', 'nilai_kriteria' => 100],

            // id_monitor = 10: Persiapan Tanam
            ['id_kriteria' => 28, 'id_monitor' => 10, 'nm_kriteria' => 'A: > 30 Cm', 'nilai_kriteria' => 90],
            ['id_kriteria' => 29, 'id_monitor' => 10, 'nm_kriteria' => 'B: 25cm S/d 30 cm', 'nilai_kriteria' => 70],
            ['id_kriteria' => 30, 'id_monitor' => 10, 'nm_kriteria' => 'C: 20 cm sS/d 25 cm', 'nilai_kriteria' => 50],

            // id_monitor = 11: Persiapan Tanam
            ['id_kriteria' => 31, 'id_monitor' => 11, 'nm_kriteria' => 'A: Rata dan gember', 'nilai_kriteria' => 90],
            ['id_kriteria' => 32, 'id_monitor' => 11, 'nm_kriteria' => 'B: Rata, tidak gembur', 'nilai_kriteria' => 70],
            ['id_kriteria' => 33, 'id_monitor' => 11, 'nm_kriteria' => 'C: Tidak rata dan tidak gembur', 'nilai_kriteria' => 50],

            // id_monitor = 12: Persiapan Tanam
            ['id_kriteria' => 34, 'id_monitor' => 12, 'nm_kriteria' => 'A: Tidak ada genagan air (tengkas)', 'nilai_kriteria' => 90],
            ['id_kriteria' => 35, 'id_monitor' => 12, 'nm_kriteria' => 'B: Pembuangan tidak lancar', 'nilai_kriteria' => 70],
            ['id_kriteria' => 36, 'id_monitor' => 12, 'nm_kriteria' => 'C: Sebagian luasan tidak bisa membuang air', 'nilai_kriteria' => 50],

            // id_monitor = 13: Persiapan Tanam
            ['id_kriteria' => 37, 'id_monitor' => 13, 'nm_kriteria' => 'A: Bisa diairi', 'nilai_kriteria' => 90],
            ['id_kriteria' => 38, 'id_monitor' => 13, 'nm_kriteria' => 'B: Bisa diari, sumber air <25 meter', 'nilai_kriteria' => 70],
            ['id_kriteria' => 39, 'id_monitor' => 13, 'nm_kriteria' => 'C: Bisa diairi, sumber air >25meter', 'nilai_kriteria' => 50],

            // id_monitor = 14: Persiapan Tanam
            ['id_kriteria' => 40, 'id_monitor' => 14, 'nm_kriteria' => 'A: bersih dari gulma', 'nilai_kriteria' => 90],
            ['id_kriteria' => 41, 'id_monitor' => 14, 'nm_kriteria' => 'B: gulma sedikit, spot-spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 42, 'id_monitor' => 14, 'nm_kriteria' => 'C: gulma 15-20% pada permukaan bedeng, dan merata', 'nilai_kriteria' => 50],

            // id_monitor = 15: Vegetatif awal
            ['id_kriteria' => 43, 'id_monitor' => 15, 'nm_kriteria' => 'A: >320 tan/bed', 'nilai_kriteria' => 90],
            ['id_kriteria' => 44, 'id_monitor' => 15, 'nm_kriteria' => 'B: 300-320 tan/bed', 'nilai_kriteria' => 70],
            ['id_kriteria' => 45, 'id_monitor' => 15, 'nm_kriteria' => 'C: 280-300 tan/bed', 'nilai_kriteria' => 50],

            // id_monitor = 16: Vegetatif awal
            ['id_kriteria' => 46, 'id_monitor' => 16, 'nm_kriteria' => 'A: Tepat waktu dan dosis', 'nilai_kriteria' => 90],
            ['id_kriteria' => 47, 'id_monitor' => 16, 'nm_kriteria' => 'B: Tidak tepat waktu tepat dosis', 'nilai_kriteria' => 70],
            ['id_kriteria' => 48, 'id_monitor' => 16, 'nm_kriteria' => 'C: tidak tepat waktu tidak tepat dosis', 'nilai_kriteria' => 50],

            // id_monitor = 17: Vegetatif awal
            ['id_kriteria' => 49, 'id_monitor' => 17, 'nm_kriteria' => 'A: Rata dan drainase lancar', 'nilai_kriteria' => 90],
            ['id_kriteria' => 50, 'id_monitor' => 17, 'nm_kriteria' => 'B: Rata dan drainase tidak lancar', 'nilai_kriteria' => 70],
            ['id_kriteria' => 51, 'id_monitor' => 17, 'nm_kriteria' => 'C: Tidak rata dan drainase tidak lancar', 'nilai_kriteria' => 50],

            // id_monitor = 18: Vegetatif awal
            ['id_kriteria' => 52, 'id_monitor' => 18, 'nm_kriteria' => 'A. Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 53, 'id_monitor' => 18, 'nm_kriteria' => 'B. Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 54, 'id_monitor' => 18, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 19: Vegetatif awal
            ['id_kriteria' => 55, 'id_monitor' => 19, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 56, 'id_monitor' => 19, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 57, 'id_monitor' => 19, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 20: Vegetatif awal
            ['id_kriteria' => 58, 'id_monitor' => 20, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 59, 'id_monitor' => 20, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 60, 'id_monitor' => 20, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 21: Vegetatif awal
            ['id_kriteria' => 61, 'id_monitor' => 21, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 62, 'id_monitor' => 21, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 63, 'id_monitor' => 21, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 22: Vegetatif awal
            ['id_kriteria' => 64, 'id_monitor' => 22, 'nm_kriteria' => 'A: Bedeng/daerah perakaran lembab', 'nilai_kriteria' => 90],
            ['id_kriteria' => 65, 'id_monitor' => 22, 'nm_kriteria' => 'B: Bedeng/daerah perakaran kapasitas lapang', 'nilai_kriteria' => 70],
            ['id_kriteria' => 66, 'id_monitor' => 22, 'nm_kriteria' => 'C: Bedeng/daerah perakaran kering, daun tidak layu', 'nilai_kriteria' => 50],

            // id_monitor = 23: Generatif awal
            ['id_kriteria' => 67, 'id_monitor' => 23, 'nm_kriteria' => 'A: Bedeng/daerah perakaran lembab', 'nilai_kriteria' => 90],
            ['id_kriteria' => 68, 'id_monitor' => 23, 'nm_kriteria' => 'B: Bedeng/daerah perakaran kapasitas lapang', 'nilai_kriteria' => 70],
            ['id_kriteria' => 69, 'id_monitor' => 23, 'nm_kriteria' => 'C: Bedeng/daerah perakaran kering, daun tidak layu', 'nilai_kriteria' => 50],

            // id_monitor = 24: Generatif awal
            ['id_kriteria' => 70, 'id_monitor' => 24, 'nm_kriteria' => 'A: bersih dari gulma', 'nilai_kriteria' => 90],
            ['id_kriteria' => 71, 'id_monitor' => 24, 'nm_kriteria' => 'B: gulma sedikit, spot-spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 72, 'id_monitor' => 24, 'nm_kriteria' => 'C: gulma 15-20% pada permukaan bedeng, dan merata', 'nilai_kriteria' => 50],

            // id_monitor = 25: Generatif awal
            ['id_kriteria' => 73, 'id_monitor' => 25, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 74, 'id_monitor' => 25, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 75, 'id_monitor' => 25, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 26: Generatif awal
            ['id_kriteria' => 76, 'id_monitor' => 26, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 77, 'id_monitor' => 26, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 78, 'id_monitor' => 26, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 27: Generatif awal
            ['id_kriteria' => 79, 'id_monitor' => 27, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 80, 'id_monitor' => 27, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 81, 'id_monitor' => 27, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 28: Generatif awal
            ['id_kriteria' => 82, 'id_monitor' => 28, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 83, 'id_monitor' => 28, 'nm_kriteria' => 'B: Terdapat imago di beberapa petak', 'nilai_kriteria' => 70],
            ['id_kriteria' => 84, 'id_monitor' => 28, 'nm_kriteria' => 'C: Ditemukan imago setiap petak', 'nilai_kriteria' => 50],

            // id_monitor = 29: Generatif Akhir
            ['id_kriteria' => 85, 'id_monitor' => 29, 'nm_kriteria' => 'A: >280 tan/bed', 'nilai_kriteria' => 90],
            ['id_kriteria' => 86, 'id_monitor' => 29, 'nm_kriteria' => 'B: 260-280 tan/bed', 'nilai_kriteria' => 70],
            ['id_kriteria' => 87, 'id_monitor' => 29, 'nm_kriteria' => 'C: < 260 Tan/bed', 'nilai_kriteria' => 50],

            // id_monitor = 30: Generatif Akhir
            ['id_kriteria' => 88, 'id_monitor' => 30, 'nm_kriteria' => 'A: >22 polong/tanaman', 'nilai_kriteria' => 90],
            ['id_kriteria' => 89, 'id_monitor' => 30, 'nm_kriteria' => 'B: 20-22 polong/tanaman', 'nilai_kriteria' => 70],
            ['id_kriteria' => 90, 'id_monitor' => 30, 'nm_kriteria' => 'C: <20 polong/tanaman', 'nilai_kriteria' => 50],

            // id_monitor = 31: Generatif Akhir
            ['id_kriteria' => 91, 'id_monitor' => 31, 'nm_kriteria' => 'A: >3 gram/polong', 'nilai_kriteria' => 90],
            ['id_kriteria' => 92, 'id_monitor' => 31, 'nm_kriteria' => 'B: 2,8 - 3 gram/polong', 'nilai_kriteria' => 70],
            ['id_kriteria' => 93, 'id_monitor' => 31, 'nm_kriteria' => 'C: <2,8 gram/polong', 'nilai_kriteria' => 50],

            // id_monitor = 32: Generatif Akhir
            ['id_kriteria' => 94, 'id_monitor' => 32, 'nm_kriteria' => 'A: Bedeng/daerah perakaran lembab', 'nilai_kriteria' => 90],
            ['id_kriteria' => 95, 'id_monitor' => 32, 'nm_kriteria' => 'B: Bedeng/daerah perakaran kapasitas lapang', 'nilai_kriteria' => 70],
            ['id_kriteria' => 96, 'id_monitor' => 32, 'nm_kriteria' => 'C: Bedeng/daerah perakaran kering, daun tidak layu', 'nilai_kriteria' => 50],

            // id_monitor = 33: Generatif Akhir
            ['id_kriteria' => 97, 'id_monitor' => 33, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 98, 'id_monitor' => 33, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 99, 'id_monitor' => 33, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 34: Generatif Akhir
            ['id_kriteria' => 100, 'id_monitor' => 34, 'nm_kriteria' => 'A: Terkendali', 'nilai_kriteria' => 90],
            ['id_kriteria' => 101, 'id_monitor' => 34, 'nm_kriteria' => 'B: Serangan Spot spot', 'nilai_kriteria' => 70],
            ['id_kriteria' => 102, 'id_monitor' => 34, 'nm_kriteria' => 'C: Serangan merata', 'nilai_kriteria' => 50],

            // id_monitor = 35: Generatif Akhir
            ['id_kriteria' => 103, 'id_monitor' => 35, 'nm_kriteria' => 'A: Tidak ditemukan ulat', 'nilai_kriteria' => 90],
            ['id_kriteria' => 104, 'id_monitor' => 35, 'nm_kriteria' => 'B: Ditemukan ulat 1 - 2', 'nilai_kriteria' => 70],
            ['id_kriteria' => 105, 'id_monitor' => 35, 'nm_kriteria' => 'C: Ditemukan ulat > 2', 'nilai_kriteria' => 50],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
