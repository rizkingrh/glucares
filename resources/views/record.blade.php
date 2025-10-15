<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glucares</title>
    <link rel="icon" href="{{ asset('img/logo-glucares.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        medical: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d'
                        },
                        healthcare: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom styles for QR scanner */
        #qr-reader {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
        }

        #qr-reader video {
            border-radius: 0.375rem;
            width: 100% !important;
            height: auto !important;
        }

        #qr-reader canvas {
            border-radius: 0.375rem;
        }

        /* Hide the default QR scanner UI elements */
        #qr-reader__dashboard_section {
            display: none !important;
        }

        #qr-reader__header_message {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-medical-50 to-healthcare-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-4 border-medical-600 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex gap-3">
                        <img src="{{ asset('img/logo-glucares.png') }}" alt="Glucares Logo" width="32">
                        <span class="text-2xl font-bold text-medical-700">Glucares</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#features"
                        class="text-gray-700 hover:text-medical-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Features</a>
                    <a href="#about"
                        class="text-gray-700 hover:text-medical-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-clipboard-list text-medical-600 mr-3"></i>
                Patient Glucose Records
            </h1>
            <p class="text-gray-600">View patient glucose monitoring history after QR code scan</p>
        </div>

        @if (!$scannedPatient)
            <!-- QR Scanner Section -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <i class="fas fa-qrcode text-6xl text-medical-400 mb-4"></i>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Scan Patient QR Code</h2>
                        <p class="text-gray-600">Choose scanning method to view patient glucose monitoring records</p>
                    </div>

                    <!-- Scanner Toggle Buttons -->
                    <div class="flex justify-center space-x-4 mb-6">
                        <button id="camera-scan-btn"
                            class="bg-medical-600 hover:bg-medical-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-camera mr-2"></i>
                            Use Camera Scanner
                        </button>
                        <button id="manual-input-btn"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            <i class="fas fa-keyboard mr-2"></i>
                            Manual Input
                        </button>
                    </div>

                    <!-- Camera Scanner Section -->
                    <div id="camera-scanner-section" class="hidden">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- QR Reader -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Camera Scanner</h3>
                                <div id="qr-reader"
                                    class="bg-gray-100 rounded-lg border-2 border-dashed border-gray-300"
                                    style="min-height: 300px;"></div>
                                <div class="flex space-x-2">
                                    <button id="start-scan-btn"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                        <i class="fas fa-play mr-2"></i>Start Scanner
                                    </button>
                                    <button id="stop-scan-btn"
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
                                        style="display: none;">
                                        <i class="fas fa-stop mr-2"></i>Stop Scanner
                                    </button>
                                </div>
                            </div>

                            <!-- Scanner Status and Results -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900">Scanner Status</h3>
                                <div class="bg-gray-50 rounded-lg p-4 min-h-[300px]">
                                    <div id="qr-status" class="text-sm text-gray-600 mb-4">
                                        Ready to scan. Click "Start Scanner" to begin.
                                    </div>

                                    <!-- Scanned Result -->
                                    <div id="scan-result" class="hidden">
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                                <span class="font-medium text-green-900">QR Code Detected!</span>
                                            </div>
                                            <div class="mt-2">
                                                <p class="text-sm text-green-700">Patient ID:</p>
                                                <p id="scanned-patient-id"
                                                    class="font-mono text-green-900 bg-white px-2 py-1 rounded border">
                                                </p>
                                            </div>
                                            <button id="load-records-btn"
                                                class="mt-3 w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                                <i class="fas fa-arrow-right mr-2"></i>Load Patient Records
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Camera Selection -->
                                    <div id="camera-selection" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select
                                            Camera:</label>
                                        <select id="camera-select"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-medical-500">
                                            <option value="">Loading cameras...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manual Input Section -->
                    <div id="manual-input-section" class="hidden">
                        <div class="max-w-md mx-auto">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Manual Patient ID Entry
                            </h3>
                            <form action="{{ route('record.qr-scan') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Patient ID (from QR Code)
                                    </label>
                                    <input type="text" name="patient_id" id="patient_id"
                                        placeholder="Enter patient ID (e.g., patient-xxxxxxxxxxxxx)"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-medical-500 focus:border-transparent"
                                        required>
                                </div>
                                <button type="submit"
                                    class="w-full bg-medical-600 hover:bg-medical-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                                    <i class="fas fa-search mr-2"></i>
                                    Load Patient Records
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="text-red-700 text-sm">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Patient Information Card -->
            <div class="bg-white rounded-xl shadow-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-user-circle text-medical-600 mr-2"></i>
                        Patient Information
                    </h2>
                    <form action="{{ route('record.clear-scan') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-sm bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-md transition-colors">
                            <i class="fas fa-times mr-1"></i>
                            Clear Scan
                        </button>
                    </form>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-id-card text-medical-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Patient ID</p>
                                <p class="font-medium text-gray-900">{{ $scannedPatient->id }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user text-medical-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium text-gray-900">{{ $scannedPatient->name ?? 'Not Available' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar text-medical-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="font-medium text-gray-900">
                                    {{ $scannedPatient->date_of_birth ? \Carbon\Carbon::parse($scannedPatient->date_of_birth)->format('M d, Y') : 'Not Available' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($scannedPatient->address || $scannedPatient->phone_number || $scannedPatient->email)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if ($scannedPatient->phone_number)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-phone text-medical-500 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Phone</p>
                                            <p class="font-medium text-gray-900">{{ $scannedPatient->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($scannedPatient->email)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-envelope text-medical-500 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="font-medium text-gray-900">{{ $scannedPatient->email }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($scannedPatient->marital_status)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-heart text-medical-500 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Marital Status</p>
                                            <p class="font-medium text-gray-900 capitalize">
                                                {{ $scannedPatient->marital_status }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($scannedPatient->address)
                                <div class="mt-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <i class="fas fa-map-marker-alt text-medical-500 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Address</p>
                                            <p class="font-medium text-gray-900">{{ $scannedPatient->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Glucose History Records -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <i class="fas fa-chart-line text-medical-600 mr-2"></i>
                            Glucose Monitoring History
                        </h2>
                        <div class="text-sm text-gray-500">
                            Total Records: {{ $paginatedHistories->total() }}
                        </div>
                    </div>
                </div>

                @if ($paginatedHistories->total() > 0)
                    <!-- Records Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Glucose Level
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($paginatedHistories as $index => $history)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ($paginatedHistories->currentPage() - 1) * $paginatedHistories->perPage() + $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                <i class="mr-1.5 text-xs"></i>
                                                {{ $history->glucose_level }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'Normal' => 'bg-green-100 text-green-800',
                                                    'Rendah' => 'bg-yellow-100 text-yellow-800',
                                                    'Diabetes' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusIcons = [
                                                    'Normal' => 'fa-check-circle',
                                                    'Rendah' => 'fa-arrow-down',
                                                    'Diabetes' => 'fa-exclamation-triangle',
                                                ];
                                                $statusClass =
                                                    $statusColors[$history->status] ?? 'bg-gray-100 text-gray-800';
                                                $statusIcon = $statusIcons[$history->status] ?? 'fa-question-circle';
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                                <i class="fas {{ $statusIcon }} mr-1.5 text-xs"></i>
                                                {{ ucfirst($history->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($paginatedHistories->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    Showing {{ $paginatedHistories->firstItem() }} to
                                    {{ $paginatedHistories->lastItem() }} of {{ $paginatedHistories->total() }}
                                    results
                                </div>
                                <div class="flex space-x-1">
                                    {{-- Previous Page Link --}}
                                    @if ($paginatedHistories->onFirstPage())
                                        <span
                                            class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                            <i class="fas fa-chevron-left mr-1"></i>Previous
                                        </span>
                                    @else
                                        <a href="{{ $paginatedHistories->previousPageUrl() }}"
                                            class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-chevron-left mr-1"></i>Previous
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($paginatedHistories->getUrlRange(1, $paginatedHistories->lastPage()) as $page => $url)
                                        @if ($page == $paginatedHistories->currentPage())
                                            <span
                                                class="px-3 py-1 text-sm text-white bg-medical-600 rounded-md">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($paginatedHistories->hasMorePages())
                                        <a href="{{ $paginatedHistories->nextPageUrl() }}"
                                            class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                            Next<i class="fas fa-chevron-right ml-1"></i>
                                        </a>
                                    @else
                                        <span
                                            class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                            Next<i class="fas fa-chevron-right ml-1"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Records Found -->
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Records Found</h3>
                        <p class="text-gray-500">This patient has no glucose monitoring history yet.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex gap-3">
                        <img src="{{ asset('img/logo-glucares.png') }}" alt="Glucares Logo" width="32">
                        <span class="text-2xl font-bold text-white">Glucares</span>
                    </a>
                </div>
                <div class="text-gray-400 text-sm">
                    © 2025 Glucares. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- HTML5 QR Code Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Additional JavaScript for Enhanced UX and QR Scanner -->
    <script>
        let qrCodeScanner = null;
        let isScanning = false;

        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
        });

        function initializeApp() {
            // Initialize UI components
            initializeToggleButtons();
            initializeManualInput();
            initializeQRScanner();
            initializeSmoothScroll();
            initializeFormLoading();
        }

        // Toggle between camera scanner and manual input
        function initializeToggleButtons() {
            const cameraScanBtn = document.getElementById('camera-scan-btn');
            const manualInputBtn = document.getElementById('manual-input-btn');
            const cameraScannerSection = document.getElementById('camera-scanner-section');
            const manualInputSection = document.getElementById('manual-input-section');

            if (cameraScanBtn && manualInputBtn) {
                cameraScanBtn.addEventListener('click', function() {
                    // Show camera scanner
                    cameraScannerSection.classList.remove('hidden');
                    manualInputSection.classList.add('hidden');

                    // Update button styles
                    cameraScanBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    cameraScanBtn.classList.add('bg-medical-600', 'hover:bg-medical-700');
                    manualInputBtn.classList.remove('bg-medical-600', 'hover:bg-medical-700');
                    manualInputBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');

                    // Initialize cameras
                    initializeCameras();
                });

                manualInputBtn.addEventListener('click', function() {
                    // Show manual input
                    manualInputSection.classList.remove('hidden');
                    cameraScannerSection.classList.add('hidden');

                    // Update button styles
                    manualInputBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    manualInputBtn.classList.add('bg-medical-600', 'hover:bg-medical-700');
                    cameraScanBtn.classList.remove('bg-medical-600', 'hover:bg-medical-700');
                    cameraScanBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');

                    // Stop scanner if running
                    stopScanner();

                    // Focus on input
                    setTimeout(() => {
                        const patientIdInput = document.getElementById('patient_id');
                        if (patientIdInput) {
                            patientIdInput.focus();
                        }
                    }, 100);
                });

                // Default to manual input
                manualInputBtn.click();
            }
        }

        // Initialize cameras for QR scanner
        function initializeCameras() {
            const cameraSelect = document.getElementById('camera-select');
            const cameraSelection = document.getElementById('camera-selection');

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    cameraSelect.innerHTML = '';
                    devices.forEach((device, index) => {
                        const option = document.createElement('option');
                        option.value = device.id;
                        option.textContent = device.label || `Camera ${index + 1}`;
                        cameraSelect.appendChild(option);
                    });
                    cameraSelection.classList.remove('hidden');
                } else {
                    updateScannerStatus('No cameras found on this device', 'error');
                }
            }).catch(err => {
                console.error('Error getting cameras:', err);
                updateScannerStatus('Error accessing cameras: ' + err, 'error');
            });
        }

        // Initialize QR Scanner functionality
        function initializeQRScanner() {
            const startBtn = document.getElementById('start-scan-btn');
            const stopBtn = document.getElementById('stop-scan-btn');

            if (startBtn && stopBtn) {
                startBtn.addEventListener('click', startScanner);
                stopBtn.addEventListener('click', stopScanner);
            }

            // Initialize load records button
            const loadRecordsBtn = document.getElementById('load-records-btn');
            if (loadRecordsBtn) {
                loadRecordsBtn.addEventListener('click', function() {
                    const patientId = document.getElementById('scanned-patient-id').textContent;
                    if (patientId) {
                        // Send to backend
                        sendQRScanResult(patientId);
                    }
                });
            }
        }

        function startScanner() {
            const cameraSelect = document.getElementById('camera-select');
            const selectedCameraId = cameraSelect.value;

            if (!selectedCameraId) {
                updateScannerStatus('Please select a camera first', 'error');
                return;
            }

            if (qrCodeScanner) {
                stopScanner();
            }

            qrCodeScanner = new Html5Qrcode("qr-reader");

            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0
            };

            updateScannerStatus('Starting camera...', 'info');

            qrCodeScanner.start(
                selectedCameraId,
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                isScanning = true;
                updateScannerStatus('Scanner active. Point camera at QR code...', 'success');

                // Toggle buttons
                document.getElementById('start-scan-btn').style.display = 'none';
                document.getElementById('stop-scan-btn').style.display = 'block';
            }).catch(err => {
                console.error('Start scanner error:', err);
                updateScannerStatus('Failed to start scanner: ' + err, 'error');
            });
        }

        function stopScanner() {
            if (qrCodeScanner && isScanning) {
                qrCodeScanner.stop().then(() => {
                    isScanning = false;
                    qrCodeScanner = null;
                    updateScannerStatus('Scanner stopped', 'info');

                    // Toggle buttons
                    document.getElementById('start-scan-btn').style.display = 'block';
                    document.getElementById('stop-scan-btn').style.display = 'none';
                }).catch(err => {
                    console.error('Stop scanner error:', err);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanner immediately
            stopScanner();

            // Show result
            document.getElementById('scanned-patient-id').textContent = decodedText;
            document.getElementById('scan-result').classList.remove('hidden');

            updateScannerStatus('QR Code successfully scanned!', 'success');
        }

        function onScanFailure(error) {
            // Called when no QR code is found in frame - this is normal
            // We don't need to update status here as it would be too noisy
        }

        function sendQRScanResult(patientId) {
            updateScannerStatus('Processing scan result...', 'info');

            // Send to Laravel backend
            fetch("{{ route('record.qr-scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    patient_id: patientId
                })
            }).then(response => {
                if (response.redirected) {
                    // Laravel returned a redirect, follow it
                    window.location.href = response.url;
                } else if (response.ok) {
                    // Success - redirect manually
                    window.location.href = "{{ route('record.index') }}?patient_id=" + encodeURIComponent(
                        patientId);
                } else {
                    updateScannerStatus('Error: Failed to process scan result', 'error');
                }
            }).catch(error => {
                console.error('Fetch error:', error);
                updateScannerStatus('Error: Failed to send scan result', 'error');
            });
        }

        function updateScannerStatus(message, type = 'info') {
            const statusElement = document.getElementById('qr-status');
            if (statusElement) {
                statusElement.textContent = message;

                // Update styling based on type
                statusElement.className = 'text-sm mb-4 ';
                switch (type) {
                    case 'success':
                        statusElement.className += 'text-green-600';
                        break;
                    case 'error':
                        statusElement.className += 'text-red-600';
                        break;
                    case 'info':
                        statusElement.className += 'text-blue-600';
                        break;
                    default:
                        statusElement.className += 'text-gray-600';
                }
            }
        }

        // Auto-focus and auto-submit for manual input
        function initializeManualInput() {
            const patientIdInput = document.getElementById('patient_id');
            if (patientIdInput) {
                // Auto-submit form when patient ID looks complete
                patientIdInput.addEventListener('input', function(e) {
                    const value = e.target.value.trim();
                    if (value.startsWith('patient-') && value.length >= 28) {
                        // Auto-submit after a short delay
                        setTimeout(() => {
                            if (e.target.value.trim() === value) {
                                e.target.closest('form').submit();
                            }
                        }, 500);
                    }
                });
            }
        }

        // Add loading state to form submission
        function initializeFormLoading() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                        submitButton.disabled = true;

                        // Re-enable if form validation fails
                        setTimeout(() => {
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        }, 5000);
                    }
                });
            });
        }

        // Smooth scroll for better UX
        function initializeSmoothScroll() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('patient_id')) {
                // Scroll to patient info section after scan
                setTimeout(() => {
                    const patientSection = document.querySelector('.bg-white.rounded-xl.shadow-lg');
                    if (patientSection) {
                        patientSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 100);
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (qrCodeScanner && isScanning) {
                qrCodeScanner.stop().catch(err => console.error('Cleanup error:', err));
            }
        });
    </script>
</body>

</html>
