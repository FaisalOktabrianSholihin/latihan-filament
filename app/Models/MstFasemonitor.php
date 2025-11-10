<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstFasemonitor extends Model
{
    use HasFactory;
    protected $table = 'mst_fasemonitors';
    protected $primaryKey = 'id_monitor';

    protected $fillable = [

        'grub_fasemonitor',
        'fase_monitoring',
        'parameter',
        'titik_kritis',
        'monitoring_poin',
        'keterangan', 
    ];

    public function kriteria()
    {
        return $this->hasMany(Kriteria::class, 'id_monitor');
    }

    public function monitortc()
    {
        return $this->hasMany(MonitorTc::class, 'id_monitor');
    }
}
