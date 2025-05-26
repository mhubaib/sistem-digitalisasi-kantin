<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    /** @use HasFactory<\Database\Factories\SantrisFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wali_id',
        'saldo',
        'rfid_code',
        'status',
        'wali_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function topups()
    {
        return $this->hasMany(Topup::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function walletHistories()
    {
        return $this->hasMany(WalletHistory::class);
    }
}
