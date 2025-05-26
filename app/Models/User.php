<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'card_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function santri()
    {
        return $this->hasOne(Santri::class);
    }

    public function waliSantri()
    {
        return $this->hasMany(Santri::class, 'wali_id');
    }

    public function topups()
    {
        return $this->hasMany(Topup::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function walletHistories()
    {
        return $this->hasMany(WalletHistory::class, 'created_by');
    } 
}
