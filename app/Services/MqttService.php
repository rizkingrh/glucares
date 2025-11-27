<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class MqttService
{
    protected $client;
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $clientId;

    public function __construct()
    {
        $config = config('services.mqtt');
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->clientId = $config['client_id'] . '_' . uniqid();
    }

    /**
     * Connect to MQTT broker
     */
    protected function connect()
    {
        try {
            $this->client = new MqttClient($this->host, $this->port, $this->clientId);
            
            $connectionSettings = new ConnectionSettings();
            if ($this->username) {
                $connectionSettings->setUsername($this->username);
            }
            if ($this->password) {
                $connectionSettings->setPassword($this->password);
            }
            
            $this->client->connect($connectionSettings);
            return true;
        } catch (\Exception $e) {
            Log::error('MQTT Connection failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Disconnect from MQTT broker
     */
    protected function disconnect()
    {
        if ($this->client && $this->client->isConnected()) {
            $this->client->disconnect();
        }
    }

    /**
     * Publish message to MQTT topic
     */
    public function publish(string $topic, array $data, int $qos = 0)
    {
        if (!$this->connect()) {
            return false;
        }

        try {
            $payload = json_encode($data);
            $this->client->publish($topic, $payload, $qos);
            Log::info("MQTT message published to topic: {$topic}", $data);
            return true;
        } catch (\Exception $e) {
            Log::error('MQTT Publish failed: ' . $e->getMessage());
            return false;
        } finally {
            $this->disconnect();
        }
    }

    /**
     * Publish patient scan data to glucares/patient topic
     */
    public function publishPatientScan(array $patientData)
    {
        return $this->publish('glucares/patient', $patientData);
    }
}