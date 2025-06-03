<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wali Santri Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset default margins and ensure full height */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }

        body {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 16rem;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 50;
            overflow-y: auto;
            background: #166534; /* bg-green-800 */
        }

        .sidebar-icon-only {
            width: 70px;
        }

        .sidebar-icon-only .sidebar-text,
        .sidebar-icon-only .sidebar-logo-text,
        .sidebar-icon-only .sidebar-children-text {
            display: none;
        }

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

        .sidebar-icon-only .sidebar-children {
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

        /* Content wrapper as scrollable container */
        .content-wrapper {
            margin-left: 16rem;
            transition: margin-left 0.3s ease;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100vw - 16rem);
            max-width: calc(100vw - 16rem);
            overflow-y: auto; /* Enable vertical scrolling */
            position: relative; /* Explicitly set as containing block */
        }

        .content-wrapper.sidebar-icon-only {
            margin-left: 70px;
            width: calc(100vw - 70px);
            max-width: calc(100vw - 70px);
        }

        /* Navbar sticky positioning with high specificity */
        .navbar {
            position: sticky !important;
            top: 0 !important;
            z-index: 40 !important;
            background: white !important;
            border-bottom: 1px solid #e5e7eb !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            padding: 1rem 2rem;
            background: #f9fafb;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Mobile sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 60;
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

            .content-wrapper {
                margin-left: 0 !important;
                width: 100vw !important;
                max-width: 100vw !important;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 50;
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
            border-top: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .transition-margin {
            transition: margin-left 0.3s ease;
        }

        .transition-left {
            transition: left 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="overlay"></div>

    <!-- Sidebar untuk Wali -->
    <div id="sidebar" class="sidebar bg-green-800">
        @include('partials.wali.sidebar')
    </div>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="content-wrapper">
        <!-- Navbar untuk Wali (Sticky) -->
        <nav class="navbar">
            @include('partials.wali.navbar')
        </nav>

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
        <footer class="footer">
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

            function checkWidth() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-icon-only');
                    contentWrapper.classList.remove('sidebar-icon-only');
                } else {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                    sidebar.classList.remove('sidebar-icon-only');
                    contentWrapper.classList.remove('sidebar-icon-only');
                    sidebarOverlay.classList.remove('active');
                }
            }

            checkWidth();

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('sidebar-hidden');
                        sidebar.classList.toggle('sidebar-visible');
                        sidebarOverlay.classList.toggle('active');
                    } else {
                        sidebar.classList.toggle('sidebar-icon-only');
                        contentWrapper.classList.toggle('sidebar-icon-only');
                    }
                });
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.remove('sidebar-visible');
                sidebarOverlay.classList.remove('active');
            });

            window.addEventListener('resize', checkWidth);
        });
    </script>
</body>

</html>