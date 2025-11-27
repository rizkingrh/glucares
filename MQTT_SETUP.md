# MQTT Integration for Glucares

This document explains how to set up and use the MQTT integration in the Glucares application to send patient scan data to a Mosquitto broker.

## Overview

When a patient QR code is scanned, the system will automatically send the patient's ID and name to the MQTT broker on the topic `glucares/patient`.

## Setup

### 1. Environment Configuration

Add the following MQTT configuration to your `.env` file:

```env
MQTT_HOST=localhost
MQTT_PORT=1883
MQTT_USERNAME=your_username
MQTT_PASSWORD=your_password
MQTT_CLIENT_ID=glucares
```

### 2. Install Mosquitto Broker (if not already installed)

#### Windows (using Chocolatey)
```bash
choco install mosquitto
```

#### Ubuntu/Debian
```bash
sudo apt update
sudo apt install mosquitto mosquitto-clients
```

#### macOS (using Homebrew)
```bash
brew install mosquitto
```

### 3. Start Mosquitto Broker

```bash
mosquitto -v
```

## Usage

### Automatic Publishing

When a patient QR code is scanned through the `QrScanController::store()` method, the system automatically:

1. Creates a QR scan record
2. Creates a temporary scan record
3. Retrieves patient information
4. Publishes patient data to MQTT broker

### Message Format

Messages are published to the topic `glucares/patient` with the following JSON structure:

```json
{
  "id": "patient-abc123",
  "name": "John Doe",
  "scanned_at": "2025-11-27T12:00:00.000Z",
  "scanned_by": 1
}
```

### Testing MQTT Functionality

Run the test script to verify MQTT connection:

```bash
php test_mqtt.php
```

### Subscribing to Messages

To listen for patient scan messages, use a MQTT client:

```bash
mosquitto_sub -h localhost -t "glucares/patient"
```

## Architecture

### Files Involved

- **`app/Services/MqttService.php`**: Core MQTT service handling connection and publishing
- **`app/Http/Controllers/QrScanController.php`**: Controller that triggers MQTT publishing on scan
- **`config/services.php`**: MQTT configuration
- **`test_mqtt.php`**: Test script for MQTT functionality

### Service Registration

The `MqttService` is registered as a singleton in `AppServiceProvider.php` to ensure efficient connection management.

## Configuration Options

| Environment Variable | Default | Description |
|---------------------|---------|-------------|
| `MQTT_HOST` | localhost | MQTT broker hostname |
| `MQTT_PORT` | 1883 | MQTT broker port |
| `MQTT_USERNAME` | null | MQTT broker username (optional) |
| `MQTT_PASSWORD` | null | MQTT broker password (optional) |
| `MQTT_CLIENT_ID` | glucares | MQTT client identifier |

## Error Handling

- Connection failures are logged to Laravel's log system
- Publishing failures are logged with error details
- The application continues to function normally even if MQTT is unavailable

## Security Considerations

1. Use authentication (username/password) for production MQTT brokers
2. Consider using TLS encryption for sensitive data
3. Implement proper access controls on MQTT topics
4. Monitor MQTT broker logs for unauthorized access

## Troubleshooting

### Common Issues

1. **Connection Refused**: Ensure Mosquitto broker is running
2. **Authentication Failed**: Check username/password in `.env`
3. **Port Issues**: Verify MQTT_PORT matches broker configuration
4. **Firewall**: Ensure port 1883 (or custom port) is open

### Debugging

Enable Laravel logging and check logs at `storage/logs/laravel.log` for MQTT-related messages.