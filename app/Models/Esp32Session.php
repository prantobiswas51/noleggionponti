<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esp32Session extends Model
{
    protected $fillable = ['esp32_device_id', 'started_at', 'expires_at', 'active'];

    public function device()
    {
        return $this->belongsTo(Esp32Device::class);
    }
}
