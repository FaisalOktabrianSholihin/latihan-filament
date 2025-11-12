<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriterias';
    protected $primaryKey = 'id_kriteria';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        // 'id_kriteria',
        'id_monitor',
        'nm_kriteria',
        'nilai_kriteria',
    ];
    public function mstfasemonitoring()
    {
        // Satu Kriteria dimiliki oleh satu Fase Monitoring
        return $this->belongsTo(MstFasemonitor::class, 'id_monitor');
    }

    public function monitortc()
    {
        return $this->hasMany(MonitorTc::class, 'id_kriteria');
    }
}
