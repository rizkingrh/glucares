<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporaryScan extends Model
{
    use HasFactory;
    protected $table = 'temporary_scans';
    protected $guarded = ['id'];
    
    /**
     * Get the patient associated with the temporary scan.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
