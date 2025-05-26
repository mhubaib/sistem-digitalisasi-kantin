<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    /** @use HasFactory<\Database\Factories\WalletHistoriesFactory> */
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'type',
        'method',
        'amount',
        'description',
        'created_by'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
