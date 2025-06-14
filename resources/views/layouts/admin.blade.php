<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles for admin layout */
        .sidebar {
            width: 16rem;
            /* 256px */
            height: 100vh;
            /* Full viewport height */
            position: fixed;
            /* Fixed position to stay in place */
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            overflow-y: auto;
            /* Allow scrolling within sidebar if content overflows */
            z-index: 50;
            /* Above content but below overlay */
        }

        /* Icon-only mode for large screens */
        .sidebar-icon-only {
            width: 70px;
            /* 70px */
            height: 100vh;
            /* Full viewport height */
        }

        .sidebar-icon-only .sidebar-text,
        .sidebar-icon-only .sidebar-logo-text,
        .sidebar-icon-only .sidebar-status-text {
            display: none;
        }

        .sidebar-icon-only .header-logo {
            justify-content: center;
            width: 100%;
            margin: 0;
        }

        .sidebar-icon-only .header-logo .space-x-3>*+* {
            margin-left: 0;
        }

        .sidebar-icon-only .sidebar-status {
            padding: 1rem 0.5rem;
            display: none;
        }

        .sidebar-icon-only .nav-link {
            justify-content: center;
            align-self: center;
            padding: 1rem 0.5rem;
        }

        .sidebar-icon-only .nav-link i {
            margin-right: 0;
            font-size: 1.25rem;
        }

        /* Hidden sidebar for all screens */
        .sidebar-hidden {
            margin-left: -16rem;
            width: 0;
            overflow: hidden;
        }

        /* Visible sidebar for mobile */
        .sidebar-visible {
            margin-left: 0;
            width: 16rem;
        }

        /* Navbar styles */
        .navbar {
            position: fixed;
            /* Fixed position to stay at top */
            top: 0;
            left: 16rem;
            /* Match sidebar width */
            right: 0;
            z-index: 40;
            /* Below sidebar but above content */
            transition: left 0.3s ease;
        }

        .sidebar-icon-only+.navbar {
            left: 70px;
            /* Adjust for icon-only sidebar */
        }

        .sidebar-hidden+.navbar {
            left: 0;
            /* No offset when sidebar is hidden */
        }

        /* Content wrapper adjustments */
        .content-wrapper {
            margin-left: 16rem;
            /* Offset for sidebar */
            margin-top: 5.5rem;
            /* Offset for navbar */
            transition: margin-left 0.3s ease;
        }

        .sidebar-icon-only+.content-wrapper {
            margin-left: 70px;
            /* Adjust for icon-only sidebar */
            margin-right: 10px;
        }

        /* Main content */
        .main-content {
            overflow-y: auto;
            /* Allow scrolling */
            min-height: calc(100vh - 4rem);
            /* Ensure it takes at least full height minus navbar */
        }

        /* Mobile sidebar (hidden completely) */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100%;
                /* Full height */
                margin-left: -16rem;
                width: 16rem;
                transition: margin-left 0.2s ease-in-out, width 0.2s ease-in-out;
            }

            .sidebar.sidebar-visible {
                margin-left: 0;
                width: 16rem;
            }

            .sidebar-hidden {
                margin-left: -16rem !important;
                width: 0 !important;
                overflow: hidden;
            }

            .navbar {
                left: 0;
                /* No sidebar offset on mobile */
            }

            .content-wrapper {
                margin-left: 0;
                /* No sidebar offset */
                margin-top: 7rem;
                /* Keep navbar offset */
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 45;
                /* Below sidebar */
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }

        /* Custom scrollbar for admin panels */
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
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="overlay"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar untuk Admin -->
        <div id="sidebar" class="sidebar bg-white">
            @include('partials.admin.sidebar')
        </div>

        <!-- Navbar untuk Admin -->
        <div class="navbar bg-white border-b-gray-200 shadow-lg">
            @include('partials.admin.navbar')
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="content-wrapper flex-1 flex flex-col">
            <!-- Main Content -->
            <main class="main-content flex-1 p-4 md:p-8 bg-gray-100">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t-gray-200 shadow-lg py-4 px-4 md:px-8 text-center text-gray-500 text-sm">
                <p>© {{ date('Y') }} Sistem Koperasi Digital Pondok. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('content-wrapper');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const toggleButtons = document.querySelectorAll('.sidebar-toggle');

            // Function to save sidebar state to localStorage
            function saveSidebarState(isIconOnly) {
                localStorage.setItem('sidebarIconOnly', isIconOnly);
            }

            // Function to get sidebar state from localStorage
            function getSidebarState() {
                return localStorage.getItem('sidebarIconOnly') === 'true';
            }

            // Function to toggle sidebar state
            function toggleSidebar() {
                const isMobile = window.innerWidth < 768;

                if (isMobile) {
                    // Mobile: toggle between hidden and visible
                    sidebar.classList.toggle('sidebar-hidden');
                    sidebar.classList.toggle('sidebar-visible');
                    sidebarOverlay.classList.toggle('active');
                    contentWrapper.style.marginLeft = '0';
                } else {
                    // Desktop: toggle between full and icon-only
                    sidebar.classList.toggle('sidebar-icon-only');
                    sidebar.classList.remove('sidebar-hidden', 'sidebar-visible');
                    sidebarOverlay.classList.remove('active');
                    contentWrapper.style.marginLeft = sidebar.classList.contains('sidebar-icon-only') ? '70px' :
                        '16rem';

                    // Save the new state
                    saveSidebarState(sidebar.classList.contains('sidebar-icon-only'));
                }
            }

            // Set initial state
            function setInitialState() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible', 'sidebar-icon-only');
                    sidebarOverlay.classList.remove('active');
                    contentWrapper.style.marginLeft = '0';
                } else {
                    sidebar.classList.remove('sidebar-hidden', 'sidebar-visible');
                    // Check localStorage for saved state
                    const isIconOnly = getSidebarState();
                    if (isIconOnly) {
                        sidebar.classList.add('sidebar-icon-only');
                        contentWrapper.style.marginLeft = '70px';
                    } else {
                        sidebar.classList.remove('sidebar-icon-only');
                        contentWrapper.style.marginLeft = '16rem';
                    }
                }
            }

            // Apply initial state
            setInitialState();

            // Toggle sidebar when button is clicked
            toggleButtons.forEach(button => {
                button.addEventListener('click', toggleSidebar);
            });

            // Close sidebar when overlay is clicked (mobile only)
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible', 'sidebar-icon-only');
                    sidebarOverlay.classList.remove('active');
                    contentWrapper.style.marginLeft = '0';
                }
            });

            // Update sidebar state on window resize
            window.addEventListener('resize', function() {
                setInitialState();
            });
        });
    </script>
</body>

</html>
