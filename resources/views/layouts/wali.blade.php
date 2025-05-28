<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wali Santri Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles for wali layout */
        .sidebar {
            width: 16rem; /* 256px */
            transition: all 0.3s ease;
        }
        
        /* Icon-only mode for large screens */
        .sidebar-icon-only {
            width: 70px; /* 80px */
        }
        
        .sidebar-icon-only .sidebar-text,
        .sidebar-icon-only .sidebar-logo-text,
        .sidebar-icon-only .sidebar-children-text {
            display: none;
        }
        
        /* Tambahkan CSS untuk header logo */
        .sidebar-icon-only .header-logo {
            justify-content: center;
            width: 100%;
            margin: 0;
        }
        
        .sidebar-icon-only .header-logo > div {
            margin: 0;
        }
        
        .sidebar-icon-only .header-logo .space-x-3 > * + * {
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
        
        /* Mobile sidebar (hidden completely) */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                height: 100%;
                margin-left: -16rem;
                transition: margin-left 0.2s ease-in-out;
            }
            
            .sidebar.sidebar-visible {
                margin-left: 0;
            }
            
            .sidebar-hidden {
                margin-left: -16rem !important; /* Force complete hiding on mobile */
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
        
        /* Content transition */
        .content-wrapper {
            transition: margin-left 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="overlay"></div>
    
    <div class="flex min-h-screen">
        <!-- Sidebar untuk Wali -->
        <div id="sidebar" class="sidebar min-h-full">
            @include('partials.wali.sidebar')
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="flex-1 flex flex-col">
            <!-- Navbar untuk Wali -->
            @include('partials.wali.navbar')

            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-8 bg-gray-100">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t py-4 px-4 md:px-8 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Sistem Koperasi Digital Pondok. All rights reserved.</p>
            </footer>
        </div>
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
                    contentWrapper.style.marginLeft = '0';
                } else {
                    // Desktop view - sidebar fully visible by default
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                    sidebarOverlay.classList.remove('active');
                    contentWrapper.style.marginLeft = '0';
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