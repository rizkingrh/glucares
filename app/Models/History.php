<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    // Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
