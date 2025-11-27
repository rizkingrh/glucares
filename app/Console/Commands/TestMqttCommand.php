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
    protected $signature = 'mqtt:test';

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
        $mqttService = app(MqttService::class);
        
        $this->info('Testing MQTT connection and publishing...');
        
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
            $this->info('✅ MQTT message published successfully!');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Failed to publish MQTT message');
            $this->error('Please check your MQTT configuration and ensure the broker is running');
            return Command::FAILURE;
        }
    }
}
