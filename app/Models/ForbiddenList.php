<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ForbiddenList extends Model
{
    use HasFactory;

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function tels() {
        return $this->hasMany(Tel::class);
    }
}
