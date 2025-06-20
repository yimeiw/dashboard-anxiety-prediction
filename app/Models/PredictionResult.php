<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PredictionResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'input_data',
        'prediction',
        'suggestion',
    ];

    protected $casts = [
        'input_data' => 'array',
    ];
}
