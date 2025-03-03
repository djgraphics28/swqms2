<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Water Quality Monitoring</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Smart Water Quality Monitoring System</a>
            <div class="space-x-4">
                <a href="#home" class="hover:underline">Home</a>
                <a href="#about" class="hover:underline">About</a>
                <a href="#contact" class="hover:underline">Contact Us</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:underline">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hover:underline">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="flex items-center justify-center min-h-screen bg-blue-500 text-white">
        <div class="text-center">
            <h1 class="text-4xl font-bold">Smart Water Quality Monitoring System</h1>
            <p class="mt-4 text-lg">Monitor and analyze water quality in real-time for a healthier environment.</p>
            <a href="#about" class="mt-6 inline-block bg-white text-blue-600 px-6 py-2 rounded-md">Learn More</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-blue-600">About Us</h2>
            <p class="mt-4 text-gray-700 max-w-2xl mx-auto">
                Our system provides real-time water quality monitoring using advanced IoT sensors and data analytics.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-blue-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-blue-600">Contact Us</h2>
            <p class="mt-4 text-gray-700">For inquiries, reach out to us via email or phone.</p>
            <p class="mt-2 text-gray-600">Email: support@watermonitoring.com</p>
            <p class="text-gray-600">Phone: +123 456 7890</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center p-4">
        &copy; 2024 Smart Water Quality Monitoring. All rights reserved.
    </footer>

</body>

</html>
