@extends('layouts.santri')

@section('title', 'Notifikasi')

@section('content')
    <div class="container mx-auto px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('santri.dashboard') }}"
                class="hover:text-blue-500 flex items-center transition-colors duration-200">
                <i class="fas fa-home mr-2 text-xs"></i> Dashboard
            </a>
            <span class="mx-3 text-gray-300">•</span>
            <span class="text-gray-600 font-medium">Notifikasi</span>
        </nav>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-light text-gray-800 mb-2">Notifikasi</h1>
                    <p class="text-gray-500 text-sm">Riwayat notifikasi sistem</p>
                </div>
                @if ($unreadCount > 0)
                    <button onclick="markAllAsRead()"
                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-check-double text-sm"></i>
                        Tandai Semua Dibaca
                    </button>
                @endif
            </div>
        </div>

        <!-- Notifications Container -->
        <div class="space-y-8">
            @forelse($notifications as $date => $dateNotifications)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                    <!-- Date Header -->
                    <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                        <h2 class="text-sm font-medium text-gray-600">
                            @if ($date == now()->format('Y-m-d'))
                                Hari Ini
                            @elseif($date == now()->subDay()->format('Y-m-d'))
                                Kemarin
                            @else
                                {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM Y') }}
                            @endif
                        </h2>
                    </div>

                    <!-- Notifications List -->
                    <div class="divide-y divide-gray-100">
                        @foreach ($dateNotifications as $notification)
                            <div class="notification-item p-6 hover:bg-gray-50/50 transition-colors duration-150 {{ $notification->is_read ? '' : 'bg-blue-50/30' }}"
                                data-id="{{ $notification->id }}">
                                <div class="flex items-start gap-4">
                                    <!-- Icon -->
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                        {{ $notification->type === 'santri_transaction'
                                            ? 'bg-green-100 text-green-600'
                                            : ($notification->type === 'topup'
                                                ? 'bg-blue-100 text-blue-600'
                                                : ($notification->type === 'expense'
                                                    ? 'bg-red-100 text-red-600'
                                                    : 'bg-gray-100 text-gray-600')) }}">
                                        @if ($notification->type === 'santri_transaction')
                                            <i class="fas fa-shopping-cart"></i>
                                        @elseif($notification->type === 'topup')
                                            <i class="fas fa-coins"></i>
                                        @elseif($notification->type === 'expense')
                                            <i class="fas fa-money-bill-wave"></i>
                                        @else
                                            <i class="fas fa-bell"></i>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h3>
                                            <span
                                                class="text-xs text-gray-500">{{ $notification->created_at->format('H:i') }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">{{ $notification->message }}</p>
                                        @if ($notification->data)
                                            <div class="text-xs text-gray-500">
                                                @if (isset($notification->data['santri_id']))
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100">
                                                        <i class="fas fa-user mr-1"></i>
                                                        ID Santri: {{ $notification->data['santri_id'] }}
                                                    </span>
                                                @endif
                                                @if (isset($notification->data['transaction_id']))
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 ml-2">
                                                        <i class="fas fa-receipt mr-1"></i>
                                                        ID Transaksi: {{ $notification->data['transaction_id'] }}
                                                    </span>
                                                @endif
                                                @if (isset($notification->data['amount']))
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 ml-2">
                                                        <i class="fas fa-money-bill mr-1"></i>
                                                        Jumlah: Rp
                                                        {{ number_format($notification->data['amount'], 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Read Status -->
                                    @if (!$notification->is_read)
                                        <button onclick="markAsRead({{ $notification->id }})"
                                            class="ml-4 p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <i class="fas fa-check text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada notifikasi</h3>
                    <p class="text-gray-500 text-sm">Belum ada notifikasi yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function markAsRead(id) {
            fetch(`/wali/notifications/${id}/read`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notification = document.querySelector(`.notification-item[data-id="${id}"]`);
                        notification.classList.remove('bg-blue-50/30');
                        const readButton = notification.querySelector('button');
                        if (readButton) {
                            readButton.remove();
                        }
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function markAllAsRead() {
            fetch('/wali/notifications/mark-all-read', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.remove('bg-blue-50/30');
                            const readButton = item.querySelector('button');
                            if (readButton) {
                                readButton.remove();
                            }
                        });
                        updateUnreadCount();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateUnreadCount() {
            const unreadCount = document.querySelectorAll('.notification-item.bg-blue-50/30').length;
            const markAllButton = document.querySelector('button[onclick="markAllAsRead()"]');

            if (unreadCount === 0 && markAllButton) {
                markAllButton.remove();
            }
        }
    </script>

    <style>
        .notification-item {
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            transform: translateX(4px);
        }

        .notification-item:not(:last-child) {
            border-bottom: 1px solid #f3f4f6;
        }
    </style>
@endsection
