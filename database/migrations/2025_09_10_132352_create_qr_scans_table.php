<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qr_scans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('patient_id'); 
            $table->foreignId('scanned_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('scanned_at')->useCurrent();

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_scans');
    }
};
