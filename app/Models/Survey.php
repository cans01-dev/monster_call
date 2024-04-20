<?php

namespace App\Models;

use App\Libs\MyUtil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class Survey extends Model
{
    use HasFactory, HasRelationships;

    protected $fillable = [
        'title',
        'note',
        'voice_name',
        'success_ending_id',
        'greeting',
        'greeting_voice_file'
    ];

    public function faqs() {
        return $this->hasMany(Faq::class);
    }

    public function options() {
        return $this->hasManyThrough(Option::class, Faq::class);
    }

    public function endings() {
        return $this->hasMany(Ending::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function areas() {
        return $this->hasMany(Area::class);
    }

    public function tel_lists() {
        return $this->hasMany(TelList::class);
    }

    public function forbidden_lists() {
        return $this->hasMany(ForbiddenList::class);
    }

    public function forbidden_tels() {
        return $this->hasManyThrough(Tel::class, ForbiddenList::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function calls() {
        return $this->hasManyThrough(Call::class, Reservation::class);
    }

    public function answers() {
        return $this->hasManyDeep(Answer::class, [Reservation::class, Call::class]);
    }

    public function success_ending_options() {
        return $this->options()->where('next_ending_id', $this->success_ending_id)->get();
    }

    public function greeting_voice_file_url() {
        return Storage::url("users/{$this->user_id}/{$this->greeting_voice_file}");
    }

    public function first_faq_options() {
        return $this->faqs()->where('order_num', 1)->first()->options;
    }

    public function greeting_voice_file_update(): string {
        $file_contents = $this->text_to_speech($this->greeting);

        if ($this->greeting_voice_file) {
            storage::disk('public')->put("users/{$this->user_id}/{$this->greeting_voice_file}", $file_contents);
            return $this->greeting_voice_file;
        } else {
            $file_name = uniqid() . '.wav';
            storage::disk('public')->put("users/{$this->user_id}/{$file_name}", $file_contents);
            return $file_name;
        }
    }

    public function get_random_answers () {
        $faqs = $this->faqs;
        $answers = [];
        $next_id = $faqs[0]["id"];
        $next_type = "faq";
        while (true) {
            $faq = $faqs->first(function ($faq) use ($next_id) {
                return $faq->id == $next_id;
            });
            
            $option = $faq->options->random();
            
            $next_type = $option->next_ending_id > 0 ? "ending" : "faq";
            $next_id = $next_type === "ending" ? $option->next_ending_id : $option->next_faq_id;
            $answers[] = [
                "id" => $faq["id"],
                "option_id" => $option["id"],
            ];
            if ($next_type === "ending") break;
        }
        return $answers;
    }

    public function text_to_speech($text) {
        $textToSpeechClient = new TextToSpeechClient();
    
        $input = new SynthesisInput();
        $input->setText($text);
        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode('ja-JP');
        $voice->setName($this->voice_name);
        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::LINEAR16);
        $audioConfig->setSpeakingRate($this->speaking_rate);
    
        $res = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
    
        return $res->getAudioContent();
      }
}
