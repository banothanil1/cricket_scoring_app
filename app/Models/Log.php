<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['batsman', 'isout', 'hisruns', 'bowler', 'onthisbowl', 'current_runs', 'current_wickets', 'current_over', 'count'];

    public function batsman()
    {
        return $this->belongsTo(Batsman::class);
    }

    public function bowler()
    {
        return $this->belongsTo(Bowler::class);
    }
}
