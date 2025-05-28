@extends('layouts.admin')

@section('title', 'Persetujuan Santri')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 md:mb-8">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Daftar Santri Menunggu Persetujuan</h1>
        <p class="text-gray-600">Kelola pendaftaran santri baru</p>
    </div>

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

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">Santri Baru</h2>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">{{ $pendingSantris->count() }} Menunggu</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-gray-500 border-b bg-gray-50">
                        <th class="text-left py-3 px-4 font-medium">Nama</th>
                        <th class="text-left py-3 px-4 font-medium">Email</th>
                        <th class="text-left py-3 px-4 font-medium">Email Wali</th>
                        <th class="text-left py-3 px-4 font-medium">Tanggal Daftar</th>
                        <th class="text-left py-3 px-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingSantris as $santri)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">{{ $santri->name }}</td>
                        <td class="py-3 px-4">{{ $santri->email }}</td>
                        <td class="py-3 px-4">{{ $santri->santri->wali_email ?? 'Tidak ada' }}</td>
                        <td class="py-3 px-4 text-gray-500">{{ $santri->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <form action="{{ route('admin.santri.approve', $santri->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors">
                                    <i class="fas fa-check mr-1"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.santri.reject', $santri->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition-colors">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">Tidak ada santri menunggu persetujuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection