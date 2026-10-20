<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailPekerjaPhk extends Model
{
    protected $table = 'detail_pekerja_phk';
    protected $primaryKey = 'detail_pekerja_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'detail_pekerja_id',
        'pelaporan_phk_id',
        'nama_pekerja',
        'nik',
        'nomor_kpj',
        'jabatan',
        'masa_kerja',
        'uang_pesangon',
        'uang_penghargaan',
        'uang_penggantian_hak',
        'total_kompensasi',
    ];

    protected $casts = [
        'uang_pesangon' => 'decimal:2',
        'uang_penghargaan' => 'decimal:2',
        'uang_penggantian_hak' => 'decimal:2',
        'total_kompensasi' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->detail_pekerja_id)) {
                $model->detail_pekerja_id = (string) Str::uuid();
            }

            // Hitung total otomatis jika belum dihitung
            if (empty($model->total_kompensasi) || $model->total_kompensasi == 0) {
                $model->total_kompensasi = (float)$model->uang_pesangon + (float)$model->uang_penghargaan + (float)$model->uang_penggantian_hak;
            }
        });
    }

    public function pelaporan()
    {
        return $this->belongsTo(PelaporanPhk::class, 'pelaporan_phk_id', 'pelaporan_phk_id');
    }
}
