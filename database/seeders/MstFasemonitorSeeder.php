<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MstFasemonitor;

class MstFasemonitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasemonitors = [
            [
                'id_monitor' => 1,
                'grub_fasemonitor' => 'Persiapan Lahan',
                'fase_monitoring' => 'Pembersihan Lahan',
                'parameter' => 'Kebersihan',
                'titik_kritis' => 'Sisa tanaman dan gulma',
                'monitoring_poin' => 'Memastikan lahan bersih dari sisa tanaman sebelumnya',
                'bobot' => '20',
                'keterangan' => 'Fase awal sebelum penanaman',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 2,
                'grub_fasemonitor' => 'Persiapan Lahan',
                'fase_monitoring' => 'Pengolahan Tanah',
                'parameter' => 'Struktur Tanah',
                'titik_kritis' => 'Kegemburan tanah',
                'monitoring_poin' => 'Tanah harus gembur dan siap tanam',
                'bobot' => '20',
                'keterangan' => 'Pengolahan dengan bajak atau cangkul',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 3,
                'grub_fasemonitor' => 'Penanaman',
                'fase_monitoring' => 'Pemilihan Benih',
                'parameter' => 'Kualitas Benih',
                'titik_kritis' => 'Daya kecambah minimal 80%',
                'monitoring_poin' => 'Benih harus bersertifikat dan berkualitas',
                'bobot' => '15',
                'keterangan' => 'Gunakan benih unggul',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 4,
                'grub_fasemonitor' => 'Penanaman',
                'fase_monitoring' => 'Jarak Tanam',
                'parameter' => 'Spacing',
                'titik_kritis' => 'Jarak tanam sesuai standar',
                'monitoring_poin' => 'Jarak tanam harus optimal untuk pertumbuhan',
                'bobot' => '10',
                'keterangan' => 'Sesuai dengan jenis tanaman',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 5,
                'grub_fasemonitor' => 'Pemeliharaan',
                'fase_monitoring' => 'Penyiraman',
                'parameter' => 'Kelembaban',
                'titik_kritis' => 'Kelembaban tanah',
                'monitoring_poin' => 'Tanah tidak boleh terlalu kering atau tergenang',
                'bobot' => '15',
                'keterangan' => 'Sesuaikan dengan kebutuhan air tanaman',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 6,
                'grub_fasemonitor' => 'Pemeliharaan',
                'fase_monitoring' => 'Pemupukan',
                'parameter' => 'Nutrisi',
                'titik_kritis' => 'Dosis pupuk',
                'monitoring_poin' => 'Pemupukan sesuai umur dan kebutuhan tanaman',
                'bobot' => '15',
                'keterangan' => 'Gunakan pupuk organik dan anorganik',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 7,
                'grub_fasemonitor' => 'Pengendalian',
                'fase_monitoring' => 'Hama dan Penyakit',
                'parameter' => 'Serangan OPT',
                'titik_kritis' => 'Intensitas serangan',
                'monitoring_poin' => 'Monitoring rutin untuk deteksi dini',
                'bobot' => '20',
                'keterangan' => 'Pengendalian terpadu',
                'field1' => '',
                'field2' => '',
            ],
            [
                'id_monitor' => 8,
                'grub_fasemonitor' => 'Panen',
                'fase_monitoring' => 'Waktu Panen',
                'parameter' => 'Umur Tanaman',
                'titik_kritis' => 'Kematangan optimal',
                'monitoring_poin' => 'Panen pada waktu yang tepat',
                'bobot' => '10',
                'keterangan' => 'Sesuai dengan karakteristik komoditas',
                'field1' => '',
                'field2' => '',
            ],
        ];

        foreach ($fasemonitors as $fasemonitor) {
            MstFasemonitor::create($fasemonitor);
        }
    }
}
