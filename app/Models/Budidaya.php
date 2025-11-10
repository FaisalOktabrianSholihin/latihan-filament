<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Budidaya extends Model
{
    use HasFactory;

    protected $table = 'budidayas';
    protected $primaryKey = 'id_budidaya';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_budidaya',
        'id_asman_manager',
        'nm_asman_manager',
        'id_atasan',
    ];

    // Relasi 1:M (One-to-Many) ke tabel TC
    public function tc()
    {
        // Satu Penanggung Jawab (ASMAN/Manager) bertanggung jawab atas banyak Trace Code (tb_tc)
        // Relasi ini menggunakan Kunci Lokal id_budidaya yang sama dengan FK id_tc di tabel anak.
        return $this->hasMany(Tc::class, 'id_budidaya');
    }
    protected function namaAtasan(): Attribute
    {
        // Data Lookup: Tempatkan pemetaan kode ke nama di sini.
        // Ganti dengan data lengkap Atasan Anda.
        $lookup = [
            '013' => 'Dodi W',
            '012' => 'Sutikno A',
            '008' => 'M. Nurhadi',
            '009' => 'Wido S',
            '391' => 'Nanang Priwahyudi',
            '307' => 'Abdul Hamid',
            '023' => 'Dedy Wahyudi',
            // ... Tambahkan pemetaan kode-nama lainnya
        ];

        return Attribute::make(
            // Fungsi 'get' mengambil kode dari kolom 'id_atasan' dan mengembalikannya sebagai nama
            get: fn(mixed $value, array $attributes) => $lookup[$attributes['id_atasan']] ?? 'Tidak Diketahui',
        );
    }
}
