@extends('layouts.santri')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Profil Santri</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="avatar-placeholder mb-3">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-3">Informasi Pribadi</h5>
                                <div class="mb-2">
                                    <strong>Nama:</strong>
                                    <span>{{ $user->name }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Email:</strong>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $santri->status === 'approved' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($santri->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Informasi Keuangan</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <strong>Saldo:</strong>
                                                    <span class="text-primary fw-bold">Rp
                                                        {{ number_format($santri->saldo, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <strong>Kode RFID:</strong>
                                                    <span>{{ $santri->rfid_code ?? 'Belum ada' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($santri->wali)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="mb-3">Informasi Wali</h5>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <strong>Nama Wali:</strong>
                                                        <span>{{ $santri->wali->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2">
                                                        <strong>Email Wali:</strong>
                                                        <span>{{ $santri->wali->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-placeholder {
            width: 100px;
            height: 100px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .avatar-placeholder i {
            color: #6c757d;
        }
    </style>
@endsection
