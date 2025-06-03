<header class="bg-white border-b shadow-sm px-4 md:px-8 py-4 flex justify-between items-center relative">
    <div class="flex items-center">
        <!-- Hamburger menu untuk toggle sidebar -->
        <button
            class="sidebar-toggle mr-4 text-gray-500 hover:text-indigo-600 focus:outline-none transition-colors duration-200 p-2 hover:bg-gray-50 rounded-lg"
            title="Toggle Sidebar">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-bold text-gray-800 tracking-tight">@yield('title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="flex items-center space-x-6">
        <!-- Notifications Dropdown -->
        <div class="relative" id="notifications-dropdown">
            <button
                class="notification-toggle relative p-2 text-gray-500 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <i class="fas fa-bell text-lg"></i>
                <span id="notification-badge"
                    class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse">3</span>
            </button>

            <!-- Notifications Dropdown Menu -->
            <div id="notifications-menu"
                class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                        <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Mark all read</button>
                    </div>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <!-- Notification Items -->
                    <div
                        class="notification-item p-4 hover:bg-gray-50 transition-colors duration-150 border-b border-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">New member registration</p>
                                <p class="text-xs text-gray-500 mt-1">John Doe has registered as a new member</p>
                                <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                            </div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                        </div>
                    </div>

                    <div
                        class="notification-item p-4 hover:bg-gray-50 transition-colors duration-150 border-b border-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-coins text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">Payment received</p>
                                <p class="text-xs text-gray-500 mt-1">Rp 500,000 payment from member savings</p>
                                <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                            </div>
                            <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                        </div>
                    </div>

                    <div
                        class="notification-item p-4 hover:bg-gray-50 transition-colors duration-150 border-b border-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-yellow-600 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">Loan payment reminder</p>
                                <p class="text-xs text-gray-500 mt-1">3 members have pending loan payments</p>
                                <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-t border-gray-100">
                    <button
                        class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium py-2 hover:bg-indigo-50 rounded-lg transition-colors duration-150">
                        View all notifications
                    </button>
                </div>
            </div>
        </div>

        <!-- Admin Profile Dropdown -->
        <div class="relative" id="profile-dropdown">
            <button
                class="profile-toggle flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-800 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">
                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-600 font-medium">Wali santri</p>
                </div>
                <i class="fas fa-chevron-down text-gray-400 text-xs ml-2 transition-transform duration-200"></i>
            </button>

            <!-- Profile Dropdown Menu -->
            <div id="profile-menu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-800 rounded-full flex items-center justify-center shadow-md">
                            <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-green-600 font-medium">Wali santri</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-150">
                        <i class="fas fa-user-circle w-5 h-5 mr-3 text-gray-400"></i>
                        Your Profile
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-150">
                        <i class="fas fa-cog w-5 h-5 mr-3 text-gray-400"></i>
                        Settings
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-150">
                        <i class="fas fa-history w-5 h-5 mr-3 text-gray-400"></i>
                        Activity Log
                    </a>
                </div>

                <div class="border-t border-gray-100 py-2">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-150">
                            <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    /* Enhanced navbar styles */
    .notification-toggle:hover .fas.fa-bell {
        animation: swing 0.5s ease-in-out;
    }

    @keyframes swing {

        15%,
        25%,
        35%,
        45%,
        55%,
        65%,
        75% {
            transform: rotate(10deg);
        }

        20%,
        30%,
        40%,
        50%,
        60%,
        70% {
            transform: rotate(-10deg);
        }

        80% {
            transform: rotate(5deg);
        }

        90% {
            transform: rotate(-5deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .profile-toggle:hover .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Dropdown animations */
    .dropdown-enter {
        opacity: 1;
        transform: scale(1);
    }

    .dropdown-exit {
        opacity: 0;
        transform: scale(0.95);
    }

    /* Notification badge pulse animation */
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    /* Custom scrollbar for notifications */
    .max-h-96::-webkit-scrollbar {
        width: 4px;
    }

    .max-h-96::-webkit-scrollbar-track {
        background: transparent;
    }

    .max-h-96::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 2px;
    }

    .max-h-96::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }

    /* Hover effects for notification items */
    .notification-item:hover {
        transform: translateX(2px);
    }

    /* Enhanced focus states */
    .sidebar-toggle:focus,
    .notification-toggle:focus,
    .profile-toggle:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Gradient borders for dropdowns */
    .dropdown-gradient-border {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1px;
        border-radius: 12px;
    }

    .dropdown-gradient-border>div {
        background: white;
        border-radius: 11px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notifications dropdown functionality
        const notificationToggle = document.querySelector('.notification-toggle');
        const notificationsMenu = document.getElementById('notifications-menu');
        const notificationBadge = document.getElementById('notification-badge');

        // Profile dropdown functionality
        const profileToggle = document.querySelector('.profile-toggle');
        const profileMenu = document.getElementById('profile-menu');

        // Toggle notifications dropdown
        notificationToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.add('hidden', 'opacity-0', 'scale-95');

            if (notificationsMenu.classList.contains('hidden')) {
                notificationsMenu.classList.remove('hidden');
                setTimeout(() => {
                    notificationsMenu.classList.remove('opacity-0', 'scale-95');
                    notificationsMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                notificationsMenu.classList.remove('opacity-100', 'scale-100');
                notificationsMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    notificationsMenu.classList.add('hidden');
                }, 200);
            }
        });

        // Toggle profile dropdown
        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationsMenu.classList.add('hidden', 'opacity-0', 'scale-95');

            if (profileMenu.classList.contains('hidden')) {
                profileMenu.classList.remove('hidden');
                setTimeout(() => {
                    profileMenu.classList.remove('opacity-0', 'scale-95');
                    profileMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                profileMenu.classList.remove('opacity-100', 'scale-100');
                profileMenu.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    profileMenu.classList.add('hidden');
                }, 200);
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            notificationsMenu.classList.remove('opacity-100', 'scale-100');
            notificationsMenu.classList.add('opacity-0', 'scale-95', 'hidden');

            profileMenu.classList.remove('opacity-100', 'scale-100');
            profileMenu.classList.add('opacity-0', 'scale-95', 'hidden');
        });

        // Prevent dropdown from closing when clicking inside
        notificationsMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        profileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Notification functionality
        function updateNotificationBadge(count) {
            if (count > 0) {
                notificationBadge.textContent = count > 99 ? '99+' : count;
                notificationBadge.classList.remove('hidden');
            } else {
                notificationBadge.classList.add('hidden');
            }
        }

        // Mark notification as read
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                const unreadDot = this.querySelector(
                    '.w-2.h-2.bg-blue-500, .w-2.h-2.bg-green-500');
                if (unreadDot) {
                    unreadDot.remove();
                    // Update badge count
                    const currentCount = parseInt(notificationBadge.textContent);
                    updateNotificationBadge(currentCount - 1);
                }
            });
        });

        // Mark all as read functionality
        document.querySelector('button:contains("Mark all read")').addEventListener('click', function() {
            document.querySelectorAll('.notification-item .w-2.h-2').forEach(dot => {
                dot.remove();
            });
            updateNotificationBadge(0);
        });

        // Simulate real-time notifications (for demo)
        setInterval(() => {
            // This would typically come from a WebSocket or polling mechanism
            // For demo purposes, we'll randomly add notifications
            if (Math.random() > 0.95) { // 5% chance every interval
                const currentCount = parseInt(notificationBadge.textContent) || 0;
                updateNotificationBadge(currentCount + 1);
            }
        }, 10000); // Check every 10 seconds
    });
</script>
