<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esp32Device extends Model
{
    protected $fillable = ['name', 'identifier'];

    public function sessions()
    {
        return $this->hasMany(Esp32Session::class);
    }
}
