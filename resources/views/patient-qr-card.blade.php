<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient ID Card - {{ $patient->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        /* Standard ID Card Size: 85.6mm × 53.98mm (3.375" × 2.125") */
        .id-card {
            width: 85.6mm;
            height: 53.98mm;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Card Header */
        .id-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 4mm 5mm 3mm 5mm;
            position: relative;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
            display: flex;
            align-items: center;
            gap: 3mm;
        }

        .id-header::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 0);
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .logo-container {
            width: 8mm;
            height: 8mm;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 1mm;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .header-text {
            flex: 1;
        }

        .hospital-name {
            font-size: 9pt;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 1mm;
        }

        .card-type {
            font-size: 5pt;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Card Body */
        .id-body {
            display: flex;
            padding: 4mm 5mm 3mm 5mm;
            gap: 4mm;
            flex: 1;
        }

        /* Left Section - QR Code */
        .id-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 25mm;
        }

        .qr-code {
            width: 24mm;
            height: 24mm;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1mm;
            background: #f8fafc;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }

        .qr-code svg {
            width: 100% !important;
            height: 100% !important;
        }

        /* Right Section - Patient Info */
        .id-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .patient-details {
            display: flex;
            flex-direction: column;
            gap: 1.5mm;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 0.5mm;
        }

        .detail-label {
            font-size: 4pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .detail-value {
            font-size: 6pt;
            color: #0f172a;
            font-weight: 600;
            line-height: 1.2;
        }

        .patient-name {
            font-size: 8pt !important;
            color: #1e40af;
            font-weight: bold;
        }

        /* Card Footer */
        .id-footer {
            background: #f8fafc;
            padding: 2mm 5mm;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .patient-id-badge {
            font-size: 6pt;
            font-weight: bold;
            color: #475569;
            font-family: 'Courier New', monospace;
        }

        .issue-date {
            font-size: 5.5pt;
            color: #64748b;
        }

        /* Print Buttons */
        .print-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 10px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        .print-info {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-top: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }

        @media print {
            @page {
                size: 85.6mm 53.98mm;
                margin: 0;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .page-container {
                margin: 0;
                padding: 0;
            }

            .id-card {
                box-shadow: none;
                page-break-inside: avoid;
                margin: 0;
            }

            .print-buttons,
            .print-info {
                display: none !important;
            }
        }

        @media screen and (max-width: 480px) {
            .id-card {
                width: 95vw;
                height: auto;
                aspect-ratio: 85.6 / 53.98;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
</head>

<body>
    <div class="page-container">
        <!-- ID Card -->
        <div class="id-card">
            <!-- Header -->
            <div class="id-header">
                <div class="logo-container">
                    <img src="{{ asset('img/logo-glucares.png') }}" alt="Glucares Logo" class="logo-img">
                </div>
                <div class="header-text">
                    <div class="hospital-name">GLUCARES</div>
                    <div class="card-type">PATIENT IDENTIFICATION CARD</div>
                </div>
            </div>

            <!-- Body -->
            <div class="id-body">
                <!-- Left: QR Code -->
                <div class="id-left">
                    <div class="qr-code">
                        {!! $qrCodeSvg !!}
                    </div>
                </div>

                <!-- Right: Patient Information -->
                <div class="id-right">
                    <div class="patient-details">
                        <div class="detail-row">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value patient-name">{{ strtoupper($patient->name) }}</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">NIK</div>
                            <div class="detail-value">{{ strtoupper($patient->nik) }}</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value">{{ $patient->gender }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="id-footer">
                <div class="patient-id-badge">ID: {{ $patient->id }}</div>
                <div class="issue-date">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Print Buttons -->
        <div class="print-buttons">
            <button onclick="generatePDF()" class="btn btn-primary">📄 Save as PDF</button>
            <button onclick="saveAsJPG()" class="btn btn-primary">🖼️ Save as JPG</button>
            <a href="javascript:window.close()" class="btn btn-secondary">✕ Close</a>
        </div>

        <div class="print-info">
            💡 <strong>Print Settings:</strong> Use "Actual Size" or "100% Scale" for correct ID card dimensions (85.6mm
            × 53.98mm)
        </div>
    </div>

    <script>
        function generatePDF() {
            window.print();
        }

        async function saveAsJPG() {
            const idCard = document.querySelector('.id-card');
            const buttons = document.querySelector('.print-buttons');
            const printInfo = document.querySelector('.print-info');

            // Hide buttons temporarily
            buttons.style.display = 'none';
            printInfo.style.display = 'none';

            try {
                const canvas = await html2canvas(idCard, {
                    scale: 4, // Higher quality
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    logging: false
                });

                // Convert to JPG
                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = 'patient-id-card-{{ $patient->id }}.jpg';
                    link.href = url;
                    link.click();
                    URL.revokeObjectURL(url);

                    // Show buttons again
                    buttons.style.display = 'flex';
                    printInfo.style.display = 'block';
                }, 'image/jpeg', 0.95);
            } catch (error) {
                console.error('Error generating JPG:', error);
                alert('Failed to generate JPG. Please try again.');
                // Show buttons again
                buttons.style.display = 'flex';
                printInfo.style.display = 'block';
            }
        }

        window.onafterprint = function() {
            console.log('Print dialog closed');
        };
    </script>
</body>

</html>
