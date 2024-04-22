<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamData extends Model
{
    use HasFactory;

    public $table='teamdatas';
    protected $fillable = [
        'team_name',
        'action'
    ];
}
