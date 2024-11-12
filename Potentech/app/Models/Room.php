<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'room_name',
    ];

    public function polls() {
        return $this->hasMany(Poll::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
