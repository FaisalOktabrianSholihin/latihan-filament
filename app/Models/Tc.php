<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tc extends Model
{
    use HasFactory;

    protected $table = 'tcs';
    protected $primaryKey = 'id_tc';
    // PENTING: Matikan auto-increment dan set keyType ke integer
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_tc',
        'tracecode',
        'id_komoditi',
        'id_budidaya',
        'tgl_tanam',
        'luas_tanam',
        'tdk_tc',
        'wilayah_tc',
    ];

    // Relasi 1:M (Many-to-One) ke Komoditi
    public function komoditi()
    {
        return $this->belongsTo(Komoditi::class, 'id_komoditi');
    }

    // Relasi 1:M (Many-to-One) ke Budidaya
    public function budidaya()
    {
        // id_tc merujuk ke id_budidaya (FK non-konvensional)
        return $this->belongsTo(Budidaya::class, 'id_budidaya');
    }

    // Relasi 1:M (One-to-Many) ke MonitorTC
    public function monitorTc()
    {
        // Foreign key: id_tc di tabel monitor_tcs
        return $this->hasMany(MonitorTc::class, 'id_tc', 'id_tc');
    }
}
