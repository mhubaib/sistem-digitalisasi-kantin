<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasEvents;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAttributes, HasTimestamps, HasEvents;

    // Field yang boleh diisi (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'card_code',
        'active',
    ];

    // Field yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting atribut ke tipe data tertentu
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Jika user ini adalah santri
    public function santri()
    {
        return $this->hasOne(Santri::class, 'user_id');
    }

    // Jika user ini adalah wali, ia memiliki banyak santri
    public function santris()
    {
        return $this->hasMany(Santri::class, 'wali_id');
    }

    // Top up yang dilakukan user
    public function topups()
    {
        return $this->hasMany(Topup::class, 'created_by');
    }

    // Transaksi yang dilakukan user
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    // Riwayat dompet user
    public function walletHistories()
    {
        return $this->hasMany(WalletHistory::class, 'created_by');
    }
    
}
