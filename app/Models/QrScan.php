<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hidehalo\Nanoid\Client;

class QrScan extends Model
{
    use HasFactory;

    protected $table = 'qr_scans';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'patient_id',
        'scanned_by',
        'scanned_at',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $nanoid = (new Client())->generateId(20);
                $model->id = 'scan-' . $nanoid;
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
