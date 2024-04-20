<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'number_of_lines'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin() {
        return $this->role_id === 2;
    }

    public function send_emails() {
        return $this->hasMany(SendEmail::class);
    }

    public function survey() {
        return $this->hasOne(Survey::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function makeDirectory() {
        Storage::makeDirectory("users/{$this->id}");
    }

    public function deleteDirectory() {
        Storage::deleteDirectory("users/{$this->id}");
    }

    public function deleteAllFile() {
        $files = Storage::files("users/{$this->id}");
        foreach ($files as $file) {
            Storage::delete($file);
        }

        return count($files);
    }

    public function init() {
        $greeting_voice_file_name = uniqid() . '.wav';
        $faq_voice_file_name = uniqid() . '.wav';
        Storage::copy('defaults/greeting.wav', "users/{$this->id}/{$greeting_voice_file_name}");
        Storage::copy('defaults/faq.wav', "users/{$this->id}/{$faq_voice_file_name}");

        $this->send_emails()->create([
            'email' => $this->email,
            'enabled' => 1
        ]);

        $survey = $this->survey()->create([
            'title' => 'アンケート１',
            'note' => 'デフォルトのアンケート',
            'greeting' => 'こんにちは、これはサンプルのアンケートです',
            'greeting_voice_file' => $greeting_voice_file_name,
            'voice_name' => 'ja-JP-Standard-A'
        ]);

        $faq = $survey->faqs()->create([
            'title' => 'デフォルトの質問',
            'text' => 'これはデフォルトの質問です、もう一度お聞きになりたい方は０を押してください。',
            'voice_file' => $faq_voice_file_name,
            'order_num' => 0
        ]);

        $faq->options()->create([
            'title' => '聞き直し',
            'dial' => 0,
            'next_faq_id' => $faq->id
        ]);

        // $survey = Fetch::find('surveys', $survey_id);
        // avfrg($survey);
    
        
        // DB::insert('favorites', [
        //     'survey_id' => $survey_id,
        //     'title' => '予約パターン１',
        //     'color' => '#DCF2F1',
        //     'start' => '17:00:00',
        //     'end' => '21:00:00'
        // ]);
        
        // DB::insert('favorites_areas', [
        //     'favorite_id' => $favorite_id,
        //     'area_id' => 1
        // ]);
    }
}
