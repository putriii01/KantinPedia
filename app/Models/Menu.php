<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'stan_name',
        'stan_phone',
        'price',
        'badge',
        'description',
        'image',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'integer',
    ];
}