<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditi extends Model
{
    use HasFactory;

    protected $table = 'komoditis';
    protected $primaryKey = 'id_komoditi';
   //diisi manual (misal 101, 102)
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_komoditi',
        'nm_komoditi',
        'ket_komoditi',
    ];

    // Relasi 1:M (One-to-Many) ke tabel Trace Code
    public function tc()
    {
        // Satu Komoditi muncul di banyak Trace Code (tb_tc)
        return $this->hasMany(Tc::class, 'id_komoditi');
    }
}
