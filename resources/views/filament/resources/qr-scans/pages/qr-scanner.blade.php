<x-filament-panels::page>
    <div class="flex flex-col items-center space-y-4">
        <div id="qr-reader" class="rounded border w-full max-w-md" style="min-height: 400px;"></div>
        <p id="qr-status" class="text-sm text-gray-500">Memuat kamera...</p>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const statusElem = document.getElementById("qr-status");
            let qrCodeScanner;

            function updateStatus(message) {
                statusElem.textContent = message;
            }

            function onScanSuccess(decodedText, decodedResult) {
                updateStatus("QR Code berhasil dipindai! Memproses...");
                
                // Stop scanner
                qrCodeScanner.stop().then(() => {
                    // Kirim ke backend via fetch API
                    fetch("{{ route('qr-scanner.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            patient_id: decodedText
                        })
                    }).then(response => {
                        if (response.ok) {
                            updateStatus("Berhasil! Kembali ke halaman QR Scans...");
                            window.location.href = "{{ url('/admin/qr-scans') }}";
                        } else {
                            updateStatus("Error: Gagal menyimpan data");
                        }
                    }).catch(error => {
                        console.error("Fetch error:", error);
                        updateStatus("Error: Gagal mengirim data");
                    });
                }).catch(err => {
                    console.error("Stop scanner error:", err);
                });
            }

            function onScanFailure(error) {
                // Handle scan failure - this is called every frame, so we don't update status here
            }

            // Start QR scanner
            qrCodeScanner = new Html5Qrcode("qr-reader");
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    updateStatus("Kamera ditemukan, memulai scanner...");
                    
                    // Use back camera if available, otherwise use first camera
                    let cameraId = devices[0].id;
                    devices.forEach(device => {
                        if (device.label.toLowerCase().includes('back') || 
                            device.label.toLowerCase().includes('environment')) {
                            cameraId = device.id;
                        }
                    });

                    const config = {
                        fps: 10,
                        qrbox: { width: 500, height: 500 },
                        aspectRatio: 1.0
                    };

                    qrCodeScanner.start(cameraId, config, onScanSuccess, onScanFailure)
                        .then(() => {
                            updateStatus("Arahkan kamera ke QR Code pasien...");
                        })
                        .catch(err => {
                            console.error("Start scanner error:", err);
                            updateStatus("Error: Gagal memulai kamera - " + err);
                        });
                } else {
                    updateStatus("Error: Tidak ada kamera yang ditemukan");
                }
            }).catch(err => {
                console.error("Get cameras error:", err);
                updateStatus("Error: Gagal mengakses kamera - " + err);
            });

            // Cleanup on page unload
            window.addEventListener('beforeunload', () => {
                if (qrCodeScanner) {
                    qrCodeScanner.stop().catch(err => console.error("Cleanup error:", err));
                }
            });
        });
    </script>
</x-filament-panels::page>
