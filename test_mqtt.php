<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\MqttService;

// Load environment variables (basic implementation for testing)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue;
        
        $parts = explode('=', $line, 2);
        if (count($parts) == 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1], '"\'');
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Test MQTT functionality
$mqttService = new MqttService();

$testData = [
    'id' => 'patient-test123',
    'name' => 'John Doe',
];

echo "Testing MQTT connection and publishing...\n";
$result = $mqttService->publishPatientScan($testData);

if ($result) {
    echo "✅ MQTT message published successfully!\n";
    echo "Topic: glucares/patient\n";
    echo "Data: " . json_encode($testData, JSON_PRETTY_PRINT) . "\n";
} else {
    echo "❌ Failed to publish MQTT message\n";
}