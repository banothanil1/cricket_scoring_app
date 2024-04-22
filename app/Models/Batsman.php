<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batsman extends Model
{
    protected $fillable = ['name', 'runs', 'balls'];
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
