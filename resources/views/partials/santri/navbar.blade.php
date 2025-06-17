<nav class="bg-white border-b border-gray-200 shadow-lg px-4 md:px-8 py-4 flex justify-between items-center relative">
    <div class="flex items-center">
        <!-- Hamburger menu untuk toggle sidebar -->
        <button
            class="sidebar-toggle mr-4 text-gray-500 hover:text-indigo-600 focus:outline-none transition-colors duration-200 p-2 hover:bg-gray-50 rounded-lg"
            title="Toggle Sidebar">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                <i class="fas fa-user text-gray-600 text-sm"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 tracking-tight">@yield('page-title', 'Dashboard')</h2>
        </div>
    </div>

    <div class="flex items-center space-x-6">
        <!-- Notifications Dropdown -->
        <div class="relative" id="notifications-dropdown">
            <button
                class="notification-toggle relative p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-bell text-lg"></i>
                @if (isset($notifications) && $notifications->count() > 0)
                    <span id="notification-badge"
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse">
                        {{ $notifications->count() }}
                    </span>
                @endif
            </button>

            <!-- Notifications Dropdown Menu -->
            <div id="notifications-menu"
                class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                        <button onclick="markAllAsRead()"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium">Mark all read</button>
                    </div>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <!-- Notification Items -->
                    <div id="notifications-container">
                        <!-- Notifikasi akan dimuat secara dinamis melalui JavaScript -->
                        <div class="p-4 text-center text-gray-500">Memuat notifikasi...</div>
                    </div>
                </div>

                <div class="p-3 border-t border-gray-100">
                    <button onclick="fetchNotifications()"
                        class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium py-2 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                        Muat Ulang Notifikasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative" id="profile-dropdown">
            <button
                class="profile-toggle flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <div
                    class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-800 font-semibold shadow-md ring-2 ring-white">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-gray-800">{{ ucfirst(Auth::user()->name ?? 'User') }}</p>
                    <p class="text-xs text-blue-600 font-medium">{{ ucfirst(Auth::user()->role ?? 'santri') }} PIT</p>
                </div>
                <i class="fas fa-chevron-down text-gray-400 text-xs ml-2 transition-transform duration-200"></i>
            </button>

            <!-- Profile Dropdown Menu -->
            <div id="profile-menu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center shadow-md">
                            <span
                                class="text-gray-800 font-semibold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-blue-600 font-medium">{{ ucfirst(Auth::user()->role ?? 'santri') }}
                            </p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="py-2">
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-150">
                        <i class="fas fa-user-circle w-5 h-5 mr-3 text-gray-400"></i>
                        Your Profile
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-150">
                        <i class="fas fa-cog w-5 h-5 mr-3 text-gray-400"></i>
                        Settings
                    </a>
                    <a href="#"
                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-all duration-150">
                        <i class="fas fa-history w-5 h-5 mr-3 text-gray-400"></i>
                        Activity Log
                    </a>
                </div>

                <div class="border-t border-gray-100 py-2">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gray-50 hover:text-red-700 transition-all duration-150">
                            <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Styles as per admin, adjusted for Santri colors */
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
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); // Using blue for focus, assuming it's Santri's color
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
        function updateNotificationBadge() {
            fetch('{{ route('santri.notifications.index') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    if (data.total_unread > 0) {
                        if (!badge) {
                            // Create badge if it doesn't exist
                            const newBadge = document.createElement('span');
                            newBadge.id = 'notification-badge';
                            newBadge.className =
                                'absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse';
                            newBadge.textContent = data.total_unread;
                            document.querySelector('.notification-toggle').appendChild(newBadge);
                        } else {
                            // Update existing badge
                            badge.textContent = data.total_unread;
                        }
                    } else {
                        // Remove badge if no notifications
                        if (badge) {
                            badge.remove();
                        }
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Update notifications every 30 seconds
        setInterval(updateNotificationBadge, 30000);

        // Initial update
        document.addEventListener('DOMContentLoaded', updateNotificationBadge);

        // Function to fetch notifications
        window.fetchNotifications = function() {
            const notificationsContainer = document.getElementById('notifications-container');
            const notificationBadge = document.getElementById('notification-badge');
            const csrfToken = document.querySelector('meta[name="csrf-token"]');

            notificationsContainer.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Memuat notifikasi...
                </div>
            `;

            fetch('/santri/notifications?_=' + new Date().getTime(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken ? {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        } : {})
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched notifications:', data);
                    notificationsContainer.innerHTML = '';
                    if (!data.notifications || data.notifications.length === 0) {
                        notificationsContainer.innerHTML = `
                        <div class="p-4 text-center text-gray-500">
                            Tidak ada notifikasi.
                        </div>
                    `;
                        if (notificationBadge) {
                            notificationBadge.classList.add('hidden');
                            notificationBadge.textContent = '0';
                        }
                        return;
                    }

                    data.notifications.forEach(notification => {
                        const item = document.createElement('div');
                        item.className =
                            'notification-item p-4 hover:bg-gray-50 transition-all duration-300 ease-in-out border-b border-gray-50 cursor-pointer';

                        item.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 ${notification.bgClass} rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas ${notification.icon} ${notification.iconColor} text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800">${notification.title}</p>
                                <p class="text-xs text-gray-500 mt-1">${notification.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${notification.created_at}</p>
                            </div>
                            <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                        </div>
                    `;

                        item.addEventListener('click', function() {
                            // Add slide-out class for animation
                            item.classList.add('slide-out');

                            // Wait for animation to complete before removing
                            setTimeout(() => {
                                fetch(`/santri/notifications/${notification.id}/read`, {
                                    method: 'PATCH',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                            .getAttribute('content')
                                    }
                                }).then(() => {
                                    item.remove();
                                    fetchNotifications();
                                });
                            }, 300); // Match this with the CSS transition duration
                        });

                        notificationsContainer.appendChild(item);
                    });
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                    notificationsContainer.innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <i class="fas fa-exclamation-circle mr-2"></i>Error loading notifications
                        </div>
                    `;
                });
        };

        // Function to mark all notifications as read
        window.markAllAsRead = function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const notificationItems = document.querySelectorAll('.notification-item');
            const markAllBtn = document.querySelector('button[onclick="markAllAsRead()"]');
            if (markAllBtn) markAllBtn.disabled = true;

            notificationItems.forEach(item => {
                item.classList.add('slide-out');
            });

            fetch('/santri/notifications/mark-all-read', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            fetchNotifications();
                            if (markAllBtn) markAllBtn.disabled = false;
                        }, 300);
                    } else {
                        console.error('Failed to mark all notifications as read:', data);
                        if (markAllBtn) markAllBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                    if (markAllBtn) markAllBtn.disabled = false;
                });
        };

        // Initial fetch
        document.addEventListener('DOMContentLoaded', fetchNotifications);
    });
</script>
