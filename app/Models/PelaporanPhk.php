<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PelaporanPhk extends Model
{
    use SoftDeletes;

    protected $table = 'pelaporan_phk';
    protected $primaryKey = 'pelaporan_phk_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pelaporan_phk_id',
        'user_id',
        'nomor_lapor',
        'nomor_bukti_lapor_dinas',
        'nama_perusahaan',
        'nib',
        'sektor_usaha',
        'alamat_perusahaan',
        'nama_kontak',
        'jabatan_kontak',
        'no_telepon',
        'email_perusahaan',
        'alasan_phk',
        'dasar_hukum',
        'tanggal_efektif_phk',
        'tanggal_pemberitahuan',
        'total_pekerja',
        'total_kompensasi',
        'file_surat_pemberitahuan',
        'file_persetujuan_pekerja',
        'file_bukti_kompensasi',
        'status',
        'catatan_verifikasi',
        'verifikator_id',
        'tanggal_diverifikasi',
    ];

    protected $casts = [
        'tanggal_efektif_phk' => 'date',
        'tanggal_pemberitahuan' => 'date',
        'tanggal_diverifikasi' => 'datetime',
        'total_pekerja' => 'integer',
        'total_kompensasi' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->pelaporan_phk_id)) {
                $model->pelaporan_phk_id = (string) Str::uuid();
            }

            if (empty($model->nomor_lapor)) {
                $countToday = static::whereDate('created_at', now()->toDateString())->count() + 1;
                $model->nomor_lapor = sprintf('PHK/PDG/%s/%04d', now()->format('Ymd'), $countToday);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id', 'user_id');
    }

    public function pekerja()
    {
        return $this->hasMany(DetailPekerjaPhk::class, 'pelaporan_phk_id', 'pelaporan_phk_id');
    }

    public function isTerverifikasi(): bool
    {
        return $this->status === 'terverifikasi';
    }

    public function isMenungguVerifikasi(): bool
    {
        return $this->status === 'menunggu_verifikasi';
    }

    public function isPerluRevisi(): bool
    {
        return $this->status === 'perlu_revisi';
    }

    public function generateNomorBuktiLapor(): string
    {
        $year = now()->format('Y');
        $romanMonth = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ][(int) now()->format('n')];

        $count = static::whereNotNull('nomor_bukti_lapor_dinas')
            ->whereYear('tanggal_diverifikasi', $year)
            ->count() + 1;

        return sprintf('560/%03d/HI-PHK/DISNAKERIN-PDG/%s/%s', $count, $romanMonth, $year);
    }
}
