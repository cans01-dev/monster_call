<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public function call () {
        return $this->belongsTo(Call::class);
    }

    public function faq () {
        return $this->belongsTo(Faq::class);
    }

    public function option () {
        return $this->belongsTo(Option::class);
    }
}
