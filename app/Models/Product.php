<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // Define fillable fields to protect against mass assignment
    protected $fillable = [
        'name',
        'delivery_status',
        'delivery_time',
        'order_id',
    ];

    // Define the relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
