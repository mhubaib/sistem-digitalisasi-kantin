<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Santri Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global box-sizing */
        * {
            box-sizing: border-box;
        }

        /* Custom styles for santri layout */
        .sidebar {
            width: 16rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            overflow-y: auto;
            z-index: 50;
        }

        /* Icon-only mode for large screens */
        .sidebar-icon-only {
            width: 70px;
        }

        .sidebar-icon-only .sidebar-text,
        .sidebar-icon-only .sidebar-logo-text,
        .sidebar-icon-only .sidebar-balance-text {
            display: none;
        }

        /* Header logo adjustments */
        .sidebar-icon-only .header-logo {
            justify-content: center;
            width: 100%;
            margin: 0;
        }

        .sidebar-icon-only .header-logo>div {
            margin: 0;
        }

        .sidebar-icon-only .header-logo .space-x-3>*+* {
            margin-left: 0;
        }

        .sidebar-icon-only .sidebar-balance {
            padding: 1rem 0.5rem;
            display: none;
        }

        .sidebar-icon-only .nav-link {
            justify-content: center;
            align-items: center;
            padding: 1rem 0.5rem;
        }

        .sidebar-icon-only .nav-link i {
            margin-right: 0;
            font-size: 1.25rem;
        }

        /* Navbar sticky positioning */
        .navbar {
            position: fixed;
            top: 0;
            left: 16rem;
            right: 0;
            z-index: 50;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            transition: left 0.3s ease;
        }

        /* Fix navbar positioning when sidebar is icon-only */
        .sidebar-icon-only~.navbar {
            left: 70px;
        }

        /* Content wrapper adjustment */
        .content-wrapper {
            margin-left: 16rem;
            margin-top: 6rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            width: calc(100% - 16rem);
        }

        .content-wrapper.sidebar-icon-only {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        .sidebar-hidden~.content-wrapper {
            margin-left: 0;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            padding: 1rem 2rem;
            background: #f9fafb;
            overflow-y: auto;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        .main-content * {
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                height: 100vh;
                margin-left: -16rem;
                transition: margin-left 0.2s ease-in-out;
                width: 16rem;
            }

            .sidebar.sidebar-visible {
                margin-left: 0;
            }

            .sidebar-hidden {
                margin-left: -16rem !important;
            }

            .navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0 !important;
                margin-top: 5rem;
                width: 100%;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Card hover effects */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Footer styling */
        .footer {
            background: white;
            border-top: 2px solid #cfcfcf;
            padding: 1rem 2rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="overlay"></div>

    <!-- Sidebar untuk Santri -->
    <div id="sidebar" class="sidebar min-h-full bg-white shadow-lg">
        @include('partials.santri.sidebar')
    </div>

    <!-- Navbar untuk Santri (Sticky) -->
    <nav class="navbar">
        @include('partials.santri.navbar')
    </nav>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="content-wrapper">

        <!-- Main Content -->
        <main class="main-content">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow"
                    role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer shadow-lg">
            <p>© {{ date('Y') }} Sistem Koperasi Digital Pondok. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Toggle sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('content-wrapper');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const toggleButtons = document.querySelectorAll('.sidebar-toggle');

            // Function to check window width and set initial sidebar state
            function checkWidth() {
                if (window.innerWidth < 768) {
                    // Mobile view - sidebar completely hidden
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-icon-only');
                    contentWrapper.classList.remove('sidebar-icon-only');
                } else {
                    // Desktop view - sidebar fully visible by default
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                    sidebar.classList.remove('sidebar-icon-only');
                    contentWrapper.classList.remove('sidebar-icon-only');
                    sidebarOverlay.classList.remove('active');
                    // Force layout refresh
                    window.dispatchEvent(new Event('resize'));
                }
            }

            // Set initial state
            checkWidth();

            // Toggle sidebar when button is clicked
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        // Mobile behavior - toggle between hidden and visible
                        sidebar.classList.toggle('sidebar-hidden');
                        sidebar.classList.toggle('sidebar-visible');
                        sidebarOverlay.classList.toggle('active');
                    } else {
                        // Desktop behavior - toggle between full and icon-only
                        sidebar.classList.toggle('sidebar-icon-only');
                        contentWrapper.classList.toggle('sidebar-icon-only');
                    }
                });
            });

            // Close sidebar when overlay is clicked
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.remove('sidebar-visible');
                sidebarOverlay.classList.remove('active');
            });

            // Update sidebar state when window is resized
            window.addEventListener('resize', checkWidth);
        });
    </script>
</body>

</html>
