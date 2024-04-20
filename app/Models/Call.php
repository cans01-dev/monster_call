<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Call extends Model
{
    use HasFactory;

    public function reservation () {
        return $this->belongsTo(Reservation::class);
    }

    public function answers () {
        return $this->hasMany(Answer::class);
    }

    public function status() {
        $status_id = $this->status;
        return collect(config('app.CALL_STATUS'))
            ->first(function ($status) use ($status_id) {
                return $status["id"] == $status_id;
            });
    }
}
