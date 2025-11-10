<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonitorTc;
use Carbon\Carbon;

class MonitorTcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monitors = [
            ['id_monitor_tc' => 1, 'id_tc' => 1, 'id_monitor' => 1, 'id_kriteria' => 1, 'nilai_monitor' => '28', 'ket_monitor' => 'Lahan sudah dibersihkan dengan baik', 'tgl_monitoring' => Carbon::parse('2025-01-10'), 'tgl_update' => Carbon::parse('2025-01-10'), 'evalusi_monitoring' => 'Pembersihan lahan sudah memenuhi standar', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 2, 'id_tc' => 1, 'id_monitor' => 3, 'id_kriteria' => 7, 'nilai_monitor' => '38', 'ket_monitor' => 'Benih bersertifikat dengan daya kecambah 85%', 'tgl_monitoring' => Carbon::parse('2025-01-13'), 'tgl_update' => Carbon::parse('2025-01-13'), 'evalusi_monitoring' => 'Kualitas benih sangat baik', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 3, 'id_tc' => 1, 'id_monitor' => 5, 'id_kriteria' => 12, 'nilai_monitor' => '35', 'ket_monitor' => 'Kelembaban tanah terjaga dengan baik', 'tgl_monitoring' => Carbon::parse('2025-01-25'), 'tgl_update' => Carbon::parse('2025-01-25'), 'evalusi_monitoring' => 'Sistem irigasi berfungsi dengan baik', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 4, 'id_tc' => 2, 'id_monitor' => 2, 'id_kriteria' => 4, 'nilai_monitor' => '38', 'ket_monitor' => 'Pengolahan tanah sudah optimal', 'tgl_monitoring' => Carbon::parse('2025-01-28'), 'tgl_update' => Carbon::parse('2025-01-28'), 'evalusi_monitoring' => 'Tanah gembur dan siap tanam', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 5, 'id_tc' => 2, 'id_monitor' => 6, 'id_kriteria' => 15, 'nilai_monitor' => '32', 'ket_monitor' => 'Pemupukan dasar sudah dilakukan', 'tgl_monitoring' => Carbon::parse('2025-02-15'), 'tgl_update' => Carbon::parse('2025-02-15'), 'evalusi_monitoring' => 'Dosis pupuk sesuai rekomendasi', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 6, 'id_tc' => 3, 'id_monitor' => 7, 'id_kriteria' => 18, 'nilai_monitor' => '30', 'ket_monitor' => 'Ditemukan sedikit ulat daun', 'tgl_monitoring' => Carbon::parse('2025-02-25'), 'tgl_update' => Carbon::parse('2025-02-25'), 'evalusi_monitoring' => 'Perlu pengendalian segera', 'hasil' => 'Perlu Perbaikan'],
            ['id_monitor_tc' => 7, 'id_tc' => 3, 'id_monitor' => 7, 'id_kriteria' => 20, 'nilai_monitor' => '23', 'ket_monitor' => 'Pengendalian hama sudah dilakukan', 'tgl_monitoring' => Carbon::parse('2025-03-01'), 'tgl_update' => Carbon::parse('2025-03-01'), 'evalusi_monitoring' => 'Serangan hama sudah terkendali', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 8, 'id_tc' => 4, 'id_monitor' => 4, 'id_kriteria' => 10, 'nilai_monitor' => '48', 'ket_monitor' => 'Jarak tanam 60x70 cm sudah tepat', 'tgl_monitoring' => Carbon::parse('2025-03-07'), 'tgl_update' => Carbon::parse('2025-03-07'), 'evalusi_monitoring' => 'Penanaman sesuai SOP', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 9, 'id_tc' => 4, 'id_monitor' => 5, 'id_kriteria' => 13, 'nilai_monitor' => '25', 'ket_monitor' => 'Penyiraman kurang teratur', 'tgl_monitoring' => Carbon::parse('2025-03-20'), 'tgl_update' => Carbon::parse('2025-03-20'), 'evalusi_monitoring' => 'Perlu perbaikan jadwal penyiraman', 'hasil' => 'Tidak Sesuai'],
            ['id_monitor_tc' => 10, 'id_tc' => 5, 'id_monitor' => 1, 'id_kriteria' => 2, 'nilai_monitor' => '38', 'ket_monitor' => 'Lahan bersih dari sisa tanaman sebelumnya', 'tgl_monitoring' => Carbon::parse('2025-03-17'), 'tgl_update' => Carbon::parse('2025-03-17'), 'evalusi_monitoring' => 'Persiapan lahan sangat baik', 'hasil' => 'Sesuai'],
            ['id_monitor_tc' => 11, 'id_tc' => 5, 'id_monitor' => 6, 'id_kriteria' => 16, 'nilai_monitor' => '33', 'ket_monitor' => 'Pemupukan susulan pertama', 'tgl_monitoring' => Carbon::parse('2025-04-05'), 'tgl_update' => Carbon::parse('2025-04-05'), 'evalusi_monitoring' => 'Waktu pemupukan sesuai jadwal', 'hasil' => 'Sesuai'],
        ];

        foreach ($monitors as $monitor) {
            MonitorTc::create($monitor);
        }
    }
}
