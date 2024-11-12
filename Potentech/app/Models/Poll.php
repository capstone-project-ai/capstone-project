<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Poll extends Model {
    use HasFactory;
    
    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = ['room_id', 'question', 'options', 'time_limit', 'created_by'];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function responses() {
        return $this->hasMany(PollResponse::class);
    }

    public function getExpiresAtAttribute() {
        return Carbon::now()->addSeconds($this->time_limit);
    }

    public function isExpired() {
        return Carbon::now()->greaterThanOrEqualTo($this->expires_at);
    }
}
