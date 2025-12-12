<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Hidehalo\Nanoid\Client;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            // Ambil ID terakhir yang memiliki prefix tersebut
            $last = self::where('id', 'LIKE', 'patient-puskesmas-cibeber-%')
                ->orderBy('id', 'desc')
                ->first();

            // Tentukan nomor increment berikutnya
            if ($last) {
                // Ambil angka paling belakang
                $lastNumber = (int) str_replace('patient-puskesmas-cibeber-', '', $last->id);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Set ID baru
            $model->id = 'patient-puskesmas-cibeber-' . $nextNumber;
        });
    }
}
