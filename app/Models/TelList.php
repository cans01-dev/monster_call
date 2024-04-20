<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class TelList extends Model
{
    use HasFactory, HasRelationships;

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function tels() {
        return $this->hasMany(Tel::class);
    }

    public function calls() {
        return $this->hasManyThrough(Call::class, Reservation::class);
    }

    public function answers() {
        return $this->hasManyDeep(Answer::class, [Reservation::class, Call::class]);
    }
}
