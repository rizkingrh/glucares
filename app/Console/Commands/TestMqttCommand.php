<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;

class TestMqttCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:test {--type=publish : Test type: publish or measurement}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test MQTT connection and publish a sample patient scan message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');

        if ($type === 'measurement') {
            $this->testMeasurementPublish();
        } else {
            $this->testPublish();
        }
    }

    /**
     * Test publishing patient data
     */
    protected function testPublish()
    {
        $mqttService = app(MqttService::class);
        
        $this->info('Testing MQTT patient scan publishing...');
        
        $testData = [
            'id' => 'patient-test' . uniqid(),
            'name' => 'Test Patient',
            'scanned_at' => now()->toISOString(),
            'scanned_by' => 1
        ];
        
        $this->info('Publishing test data to topic: glucares/patient');
        $this->line('Data: ' . json_encode($testData, JSON_PRETTY_PRINT));
        
        $result = $mqttService->publishPatientScan($testData);
        
        if ($result) {
            $this->info('✅ MQTT patient scan published successfully!');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Failed to publish MQTT patient scan');
            $this->error('Please check your MQTT configuration and ensure the broker is running');
            return Command::FAILURE;
        }
    }

    /**
     * Test publishing measurement data
     */
    protected function testMeasurementPublish()
    {
        $mqttService = app(MqttService::class);
        
        $this->info('Testing MQTT measurement data publishing...');
        
        // First, let's check if we have any patients in the database
        $patient = \App\Models\Patient::first();
        if (!$patient) {
            $this->error('No patients found in database. Please create a patient first.');
            return Command::FAILURE;
        }

        $testData = [
            'patient_id' => $patient->id,
            'glucose_level' => '120 mg/dl',
            'status' => 'Normal'
        ];
        
        $this->info('Publishing test measurement data to topic: glucares/measurement');
        $this->line('Data: ' . json_encode($testData, JSON_PRETTY_PRINT));
        
        $result = $mqttService->publish('glucares/measurement', $testData);
        
        if ($result) {
            $this->info('✅ MQTT measurement data published successfully!');
            $this->info('Note: Make sure the MQTT subscriber is running to process this data');
            $this->line('Run: php artisan mqtt:subscribe');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Failed to publish MQTT measurement data');
            $this->error('Please check your MQTT configuration and ensure the broker is running');
            return Command::FAILURE;
        }
    }
}
