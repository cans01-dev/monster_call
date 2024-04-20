<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    public function stations() {
        return $this->hasMany(Station::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }
}
