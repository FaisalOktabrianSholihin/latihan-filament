<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstFasemonitor extends Model
{
    use HasFactory;
    protected $table = 'mst_fasemonitors';
    protected $primaryKey = 'id_monitor';
    public $incrementing = false;

    protected $fillable = [
        'id_monitor',
        'grub_fasemonitor',
        'fase_monitoring',
        'parameter',
        'titik_kritis',
        'monitoring_poin',
        'bobot',
        'keterangan',
        'field1',
        'field2',
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
