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
                    <img src="{{ asset('img/logo-glucares.png') }}" alt="Glucares Logo" class="h-8 w-auto mr-3">
                    <span class="text-2xl font-bold text-medical-700">Glucares</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#features"
                        class="text-gray-700 hover:text-medical-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Features</a>
                    <a href="#about"
                        class="text-gray-700 hover:text-medical-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                    <a href="/admin"
                        class="bg-medical-600 hover:bg-medical-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-user-md mr-2"></i>Admin Login
                    </a>
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

                <!-- QR Code Scanner Button -->
                <div class="max-w-md mx-auto">
                    <div class="bg-white p-8 rounded-2xl shadow-xl border border-medical-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center justify-center">
                            <i class="fas fa-qrcode text-medical-600 mr-3 text-2xl"></i>
                            Quick Patient Check-in
                        </h3>
                        <p class="text-gray-600 mb-8">Scan patient QR code for instant access to medical records</p>

                        <button onclick="openQRScanner()"
                            class="w-full bg-gradient-to-r from-medical-600 to-medical-700 hover:from-medical-700 hover:to-medical-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-camera mr-3 text-xl"></i>
                            Scan QR Code
                        </button>

                        <div class="mt-6 text-center">
                            <span class="text-sm text-gray-500">Or</span>
                        </div>

                        <button onclick="openManualEntry()"
                            class="w-full mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl transition-colors">
                            <i class="fas fa-keyboard mr-2"></i>
                            Manual Entry
                        </button>
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
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">QR Code Integration</h3>
                        <p class="text-gray-600">Quick patient identification and data access through secure QR code
                            scanning technology.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-gradient-to-br from-medical-50 to-healthcare-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-medical-700 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics Dashboard</h3>
                        <p class="text-gray-600">Real-time insights and reporting tools to track patient outcomes and
                            operational efficiency.</p>
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
                    <img src="{{ asset('img/logo-glucares.png') }}" alt="Glucares Logo" class="h-8 w-auto mr-3">
                    <span class="text-2xl font-bold text-white">Glucares</span>
                </div>
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} Glucares. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- QR Scanner Modal (placeholder) -->
    <div id="qrModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                QR Code Scanner
                            </h3>
                            <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-camera text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">Camera will open here</p>
                                    <p class="text-sm text-gray-400 mt-2">Position QR code within the frame</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="closeQRScanner()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-medical-600 text-base font-medium text-white hover:bg-medical-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openQRScanner() {
            document.getElementById('qrModal').classList.remove('hidden');
            // Here you would integrate with a QR code scanning library
            // Example: QuaggaJS, ZXing, or html5-qrcode
        }

        function closeQRScanner() {
            document.getElementById('qrModal').classList.add('hidden');
        }

        function openManualEntry() {
            // Redirect to manual patient entry form
            window.location.href = '/patient/search';
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
