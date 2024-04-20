<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public function areas() {
        return $this->belongsToMany(Area::class, 'favorite_area');
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function tel_list() {
        return $this->belongsTo(TelList::class);
    }
}
