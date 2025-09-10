<x-filament-panels::page>
    <div class="flex flex-col items-center space-y-6">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <h2 class="text-xl font-semibold text-center mb-4">QR Code Scanner</h2>
            
            <div class="flex flex-col items-center space-y-4">
                <div id="qr-reader" class="rounded border w-full max-w-md" style="height: 300px; background-color: #f3f4f6;"></div>
                <p id="status" class="text-sm text-gray-500">Memuat kamera...</p>
                <button id="start-camera" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" style="display: none;">
                    Mulai Kamera
                </button>
            </div>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 w-full max-w-2xl">
            <h3 class="font-medium text-blue-900 mb-2">Petunjuk Penggunaan:</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• Pastikan browser memiliki izin untuk mengakses kamera</li>
                <li>• Arahkan kamera ke QR Code pasien</li>
                <li>• QR Code akan otomatis terdeteksi dan disimpan</li>
                <li>• Pastikan QR Code berada dalam kotak panduan</li>
            </ul>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const qrReader = document.getElementById("qr-reader");
            const statusElement = document.getElementById("status");
            const startButton = document.getElementById("start-camera");
            
            let qrCodeScanner = null;
            let isScanning = false;
            
            // Function to update status
            function updateStatus(message, isError = false) {
                statusElement.textContent = message;
                statusElement.className = `text-sm ${isError ? 'text-red-600' : 'text-gray-500'}`;
                console.log("Status:", message);
            }
            
            // Function to start camera
            async function startCamera() {
                if (isScanning) return;
                
                try {
                    updateStatus("Meminta izin kamera...");
                    isScanning = true;
                    
                    // Check if getUserMedia is supported
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error("Browser tidak mendukung akses kamera");
                    }
                    
                    // Initialize QR scanner
                    qrCodeScanner = new Html5Qrcode("qr-reader");
                    
                    // Get available cameras
                    const cameras = await Html5Qrcode.getCameras();
                    console.log("Available cameras:", cameras);
                    
                    if (cameras.length === 0) {
                        throw new Error("Tidak ada kamera yang ditemukan");
                    }
                    
                    // Choose camera (prefer back camera)
                    let cameraId = cameras[0].id;
                    for (let camera of cameras) {
                        const label = camera.label.toLowerCase();
                        if (label.includes('back') || label.includes('rear') || label.includes('environment')) {
                            cameraId = camera.id;
                            break;
                        }
                    }
                    
                    console.log("Using camera ID:", cameraId);
                    updateStatus("Memulai kamera...");
                    
                    // Start scanning with specific camera ID
                    await qrCodeScanner.start(
                        cameraId,
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 },
                            aspectRatio: 1.0
                        },
                        async (decodedText) => {
                            console.log("QR Code scanned:", decodedText);
                            updateStatus("QR Code terdeteksi, menyimpan...");
                            
                            // Stop camera
                            await qrCodeScanner.stop();
                            qrCodeScanner = null;
                            isScanning = false;
                            
                            // Send to backend
                            try {
                                const response = await fetch("{{ route('qr-scanner.store') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        patient_id: decodedText
                                    })
                                });
                                
                                if (response.ok) {
                                    updateStatus("Berhasil disimpan! Memuat ulang halaman...");
                                    setTimeout(() => {
                                        window.location.href = "{{ route('filament.admin.resources.qr-scans.index') }}";
                                    }, 1500);
                                } else {
                                    const errorText = await response.text();
                                    console.error("Save failed:", errorText);
                                    updateStatus("Gagal menyimpan: " + errorText, true);
                                    startButton.style.display = "block";
                                }
                            } catch (error) {
                                console.error("Network error:", error);
                                updateStatus("Error jaringan: " + error.message, true);
                                startButton.style.display = "block";
                            }
                        },
                        (errorMsg) => {
                            // Ignore scanning errors (when QR is not clearly visible)
                            // console.log("Scan error (ignored):", errorMsg);
                        }
                    );
                    
                    updateStatus("Kamera aktif - Arahkan ke QR Code pasien");
                    startButton.style.display = "none";
                    
                } catch (error) {
                    console.error("Camera error:", error);
                    isScanning = false;
                    startButton.style.display = "block";
                    
                    // Show specific error messages
                    if (error.name === 'NotAllowedError') {
                        updateStatus("Izin kamera ditolak. Silakan izinkan akses kamera dan coba lagi.", true);
                    } else if (error.name === 'NotFoundError') {
                        updateStatus("Tidak ada kamera yang ditemukan di perangkat ini.", true);
                    } else if (error.name === 'NotSupportedError') {
                        updateStatus("Browser tidak mendukung akses kamera.", true);
                    } else if (error.message.includes('Permission denied')) {
                        updateStatus("Izin kamera ditolak. Refresh halaman dan coba lagi.", true);
                    } else {
                        updateStatus("Error: " + error.message, true);
                    }
                }
            }
            
            // Button click handler
            startButton.addEventListener('click', () => {
                startButton.style.display = "none";
                startCamera();
            });
            
            // Auto start camera after page load
            updateStatus("Memeriksa dukungan kamera...");
            setTimeout(() => {
                startCamera();
            }, 1000);
        });
    </script>
</x-filament-panels::page>
