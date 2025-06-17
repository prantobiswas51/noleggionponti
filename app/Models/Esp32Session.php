<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Esp32Session extends Model
{
    protected $fillable = ['user_id','esp32_device_id', 'started_at', 'last_deducted_at', 'expires_at', 'active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Esp32Device::class);
    }
}
