<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
