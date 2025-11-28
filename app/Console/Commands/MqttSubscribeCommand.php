<?php

namespace App\Console\Commands;

use App\Models\History;
use App\Models\Patient;
use App\Services\MqttService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MqttSubscribeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe {--topic=glucares/measurement : MQTT topic to subscribe to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to MQTT topic and process measurement data';

    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        parent::__construct();
        $this->mqttService = $mqttService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $topic = $this->option('topic');
        
        $this->info("Starting MQTT subscriber for topic: {$topic}");
        $this->info("MQTT Configuration:");
        $config = config('services.mqtt');
        $this->line("  Host: {$config['host']}");
        $this->line("  Port: {$config['port']}");
        $this->line("  Client ID: {$config['client_id']}");
        $this->info("Press Ctrl+C to stop...");
        $this->line('');

        // Define callback function to process received messages
        $callback = function ($data, $receivedTopic) {
            $this->processMeasurementData($data, $receivedTopic);
        };

        // Subscribe to the topic
        if ($topic === 'glucares/measurement') {
            $this->mqttService->subscribeMeasurements($callback);
        } else {
            $this->mqttService->subscribe($topic, $callback);
        }
    }

    /**
     * Process measurement data and save to database
     */
    protected function processMeasurementData(array $data, string $topic)
    {
        try {
            $this->info("📨 Message received from topic: {$topic}");
            $this->line("Raw data: " . json_encode($data, JSON_PRETTY_PRINT));

            // Check for decode errors
            if (isset($data['decode_error'])) {
                $this->error('❌ Failed to decode JSON message');
                $this->line("Raw message: {$data['raw_message']}");
                return;
            }

            // Validate required fields
            if (!isset($data['patient_id']) || !isset($data['glucose_level']) || !isset($data['status'])) {
                $this->error('❌ Invalid message format. Required fields: patient_id, glucose_level, status');
                $this->line('Received fields: ' . implode(', ', array_keys($data)));
                Log::error('Invalid MQTT message format', $data);
                return;
            }

            // Check if patient exists
            $patient = Patient::find($data['patient_id']);
            if (!$patient) {
                $this->error("Patient not found: {$data['patient_id']}");
                Log::error("Patient not found: {$data['patient_id']}");
                return;
            }

            // Create history record
            $history = History::create([
                'patient_id' => $data['patient_id'],
                'glucose_level' => $data['glucose_level'],
                'status' => $data['status']
            ]);

            $this->info("✅ Measurement saved successfully for patient: {$patient->name}");
            $this->line("   - Glucose Level: {$data['glucose_level']}");
            $this->line("   - Status: {$data['status']}");
            $this->line("   - Record ID: {$history->id}");

            Log::info('MQTT measurement data saved', [
                'patient_id' => $data['patient_id'],
                'patient_name' => $patient->name,
                'glucose_level' => $data['glucose_level'],
                'status' => $data['status'],
                'history_id' => $history->id
            ]);

        } catch (\Exception $e) {
            $this->error("Error processing measurement data: {$e->getMessage()}");
            Log::error('Error processing MQTT measurement data', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }
}
