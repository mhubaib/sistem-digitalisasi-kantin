<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    /** @use HasFactory<\Database\Factories\TopupsFactory> */
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'created_by',
        'source',
        'method',
        'amount',
        'notes'
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
