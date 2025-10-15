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

    <!-- Hero Section -->
    <section class="py-16 lg:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Medical Icon -->
                <div class="mb-8">
                    <i class="fas fa-heartbeat text-8xl text-medical-500 mb-4"></i>
                </div>

                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl mb-6">
                    <span class="block">Advanced</span>
                    <span class="block text-medical-600">Healthcare Management</span>
                </h1>

                <p class="mt-3 text-xl text-gray-500 sm:mt-5 max-w-3xl mx-auto mb-10">
                    Streamline your healthcare operations with Glucares - a comprehensive patient management
                    system designed for modern medical practices.
                </p>

                <!-- Medical Records Access Section -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white p-8 rounded-3xl shadow-2xl border border-medical-100">
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-medical-500 to-medical-600 rounded-full mb-6">
                                <i class="fas fa-clipboard-list text-white text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">
                                Patient Medical Records
                            </h3>
                            <p class="text-gray-600 text-lg">
                                Scan patient QR code or enter patient ID to access complete glucose monitoring history
                                and medical records
                            </p>
                        </div>

                        <!-- Main Action Button -->
                        <div class="space-y-4">
                            <a href="/record"
                                class="block w-full bg-gradient-to-r from-medical-600 via-medical-700 to-medical-800 hover:from-medical-700 hover:via-medical-800 hover:to-medical-900 text-white font-bold py-5 px-8 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl text-center text-lg group">
                                <i class="fas fa-search mr-3 text-xl group-hover:animate-pulse"></i>
                                Check Medical Records
                                <div class="mt-2 text-sm text-medical-100">
                                    QR Scanner & Patient Lookup
                                </div>
                            </a>

                            <!-- Quick Access Features -->
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl text-center border border-blue-200">
                                    <i class="fas fa-qrcode text-blue-600 text-2xl mb-2"></i>
                                    <div class="text-sm font-semibold text-blue-900">QR Scanner</div>
                                    <div class="text-xs text-blue-600">Instant Access</div>
                                </div>
                                <div
                                    class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl text-center border border-green-200">
                                    <i class="fas fa-chart-line text-green-600 text-2xl mb-2"></i>
                                    <div class="text-sm font-semibold text-green-900">Glucose History</div>
                                    <div class="text-xs text-green-600">Complete Records</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-medical-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Comprehensive Healthcare Solutions
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div
                        class="bg-gradient-to-br from-medical-50 to-medical-100 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-medical-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-user-injured text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Patient Management</h3>
                        <p class="text-gray-600">Comprehensive patient records, medical history, and appointment
                            scheduling in one unified system.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-gradient-to-br from-healthcare-50 to-healthcare-100 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-healthcare-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-qrcode text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">QR Code Scanner</h3>
                        <p class="text-gray-600">Instant patient record access through secure QR code scanning with
                            real-time glucose monitoring history.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-gradient-to-br from-medical-50 to-healthcare-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-medical-700 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Glucose Monitoring</h3>
                        <p class="text-gray-600">Comprehensive glucose level tracking with historical data, status
                            indicators, and 25 records per page pagination.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div
                        class="bg-gradient-to-br from-healthcare-50 to-medical-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-healthcare-700 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Secure & HIPAA Compliant</h3>
                        <p class="text-gray-600">Bank-level security with full HIPAA compliance to protect sensitive
                            patient information.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div
                        class="bg-gradient-to-br from-medical-100 to-healthcare-100 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-medical-500 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-mobile-alt text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Mobile Responsive</h3>
                        <p class="text-gray-600">Access your healthcare management system from any device, anywhere,
                            anytime.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div
                        class="bg-gradient-to-br from-healthcare-100 to-medical-100 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-healthcare-500 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                        <p class="text-gray-600">Round-the-clock technical support to ensure your healthcare operations
                            never stop.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gradient-to-br from-medical-50 to-healthcare-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-medical-600 font-semibold tracking-wide uppercase">About Glucares</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Revolutionizing Healthcare Management
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Glucares is a state-of-the-art healthcare management system designed to streamline medical
                    operations,
                    improve patient care, and enhance operational efficiency for healthcare providers of all sizes.
                </p>
            </div>
        </div>
    </section>

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
</body>

</html>
