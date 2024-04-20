<?php

namespace App\Models;

use App\Libs\MyUtil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ending extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'voice_file'
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function voice_file_url() {
        return Storage::url("users/{$this->survey->user_id}/{$this->voice_file}");
    }

    public function voice_file_update(): string {
        $file_contents = $this->survey->text_to_speech($this->text);

        if ($this->voice_file) {
            storage::disk('public')->put("users/{$this->survey->user_id}/{$this->voice_file}", $file_contents);
            return $this->voice_file;
        } else {
            $file_name = uniqid() . '.wav';
            storage::disk('public')->put("users/{$this->survey->user_id}/{$file_name}", $file_contents);
            return $file_name;
        }
    }
}
