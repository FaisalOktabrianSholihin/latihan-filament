<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitorTc extends Model
{
    use HasFactory;

    protected $table = 'monitor_tcs';
    protected $primaryKey = 'id_monitor_tc';
    public $incrementing = false;

    protected $fillable = [
        'id_monitor_tc',
        'id_user',
        'id_tc',
        'id_kriteria',
        'id_monitor',
        'nilai_monitor',
        'ket_monitor',
        'tgl_monitoring',
        'tgl_update',
        'evalusi_monitoring',
        'hasil',
    ];

    // Set dates untuk automatic date handling
    protected $dates = [
        'tgl_monitoring',
        'tgl_update',
        'created_at',
        'updated_at',
    ];

    // Relasi ke Master Data (Semua Many-to-One)

    public function user()
    {
        // FK: id_user
        return $this->belongsTo(User::class, 'id_user');
    }

    public function fasemonitoring()
    {
        // FK: id_monitor
        return $this->belongsTo(MstFasemonitor::class, 'id_monitor');
    }

    public function tc()
    {
        // FK: tracecode (Kunci non-konvensional)
        return $this->belongsTo(Tc::class, 'id_tc');
    }

    public function kriteria()
    {
        // FK: id_kriteria
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
