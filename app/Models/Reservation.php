<?php

namespace App\Models;

use App\Mail\ReservationCollected;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Reservation extends Model
{
    use HasFactory;

    public function areas() {
        return $this->belongsToMany(Area::class, 'reservation_area');
    }

    public function stations() {
        return $this->belongs(Area::class, 'reservation_area');
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function tel_list() {
        return $this->belongsTo(TelList::class);
    }

    public function status() {
        return $this->belongsTo(ReservationStatus::class);
    }

    public function calls() {
        return $this->hasMany(Call::class);
    }

    public function answers() {
        return $this->hasManyThrough(Answer::class, Call::class);
    }

    public function get_numbers(): Collection {
        $tels_length = round(
            (strtotime($this->end_at) - strtotime($this->start_at)) / 3600
            * config('app.NUMBERS_PER_HOUR')
            * $this->survey->user->number_of_lines
        );
        $forbidden_tels = $this->survey->forbidden_tels;

        if ($tel_list = $this->tel_list) {
            $tels = $tel_list->tels->pluck('tel')
                ->diff($tel_list->calls->pluck('tel'))
                ->diff($forbidden_tels->pluck('tel'))
                ->slice(0, $tels_length);
        } else {
            $tels = collect([]);

            foreach ($this->areas as $area) {
                foreach ($area->stations()->orderBy('prefix')->get() as $station) {
                    $calls = $this->survey->calls()->where('tel', 'like', "{$station["prefix"]}%")->get();
                    $forbidden_tels = $this->survey->forbidden_tels()->where('tel', 'like', "{$station["prefix"]}%")->get();

                    $n56789s = collect(range(0, 99999))->diff($calls->map(function ($call) {
                        return intval(substr($call->tel, 6, 5));
                    }))->diff($forbidden_tels->map(function ($forbidden_tel) {
                        return intval(substr($forbidden_tel->tel, 6, 5));
                    }));
            
                    $tels = $tels->concat($n56789s->map(function ($n56789) use ($station) {
                        return substr_replace(
                            substr_replace(
                                $station->prefix . sprintf('%05d', intval($n56789)),
                            '-', 3, 0),
                        '-', 8, 0);
                    }));

                    if ($tels->count() >= $tels_length) {
                        $tels = $tels->slice(0, $tels_length);
                        break 2;
                    }
                }
            }
        }
        return $tels;
    }

    public function gen_reservation_info(): string {
        $survey = $this->survey;
        $user = $survey->user;
    
        # basis
        $array = [
            "id" => $this->id,
            "user_id" => $user->id,
            "date" => $this->date,
            "greeting" => $survey->greeting_voice_file,
            "start" => substr($this->start_at, 0, -3),
            "end" => substr($this->end_at, 0, -3),
            "faqs" => [],
            "endings" => [],
            "numbers" => []
        ];
    
        # faqs
        foreach ($survey->faqs as $faq) {
            $f = [
                "faq_id" => $faq->id,
                "voice" => $faq->voice_file,
                "options" => []
            ];
            foreach($faq->options as $option) {
                $next_type = $option->next_ending_id ? "ending" : "faq";
                $next_id = $next_type === "ending" ? $option->next_ending_id : $option->next_faq_id;
                $f["options"]["{$option->dial}"] = [
                    "option_id" => $option->id,
                    "next_type" => $next_type,
                    "next_id" => $next_id
                ];
            }
            $array["faqs"][] = $f;
        }
    
        # endings
        foreach ($survey->endings as $ending) {
            $array["endings"][] = [
                "ending_id" => $ending->id,
                "voice" => $ending->voice_file
            ];
        }
    
        # numbers
        $array["numbers"] = $this->get_numbers()->all();
    
        $contents = json_encode($array, JSON_PRETTY_PRINT);
        return $contents;
    }

    public function confirm() {
        $f_date = str_replace("-", "_", $this->date);
        $file_name = "user{$this->survey->user_id}_{$f_date}.json";
        
        $this->status_id = 2;
        $this->reservation_file = $file_name;
        $this->save();

        $file_contents = $this->gen_reservation_info();
        Storage::disk('public')->put("users/{$this->survey->user_id}/{$file_name}", $file_contents);
    }
    
    public function generate_sample_result (array $status_rand_array) {
        $survey = Survey::findOrFail($this->survey_id);
        $user = $survey->user;
    
        $array = [
            "id" => $this->id,
            "user_id" => $user->id,
            "calls" => []
        ];
    
        # calls
        foreach ($this->get_numbers() as $number) {
            $status = $status_rand_array[array_rand($status_rand_array)];
            $duration = 0;
            if ($status == 1) {
                $time = date("H:i:s", rand(strtotime($this->start_at), strtotime($this->end_at)));
                $duration = rand(10, 150);
                $answers = $survey->get_random_answers();
            }
            $array["calls"][] = [
                "number" => $number,
                "status" => $status,
                "duration" => $duration ?? null,
                "time" => $time ?? null,
                "answers" => $answers ?? null
            ];
        }
            
        $file_contents = json_encode($array, JSON_PRETTY_PRINT);
        return $file_contents;
    }

    public function receive_result ($json) {
        DB::transaction(function () use ($json) {
            foreach ($json["calls"] as $json_call) {
                $call = new Call();
                $call->reservation_id = $this["id"];
                $call->tel = str_replace('-', '', $json_call["number"]);
                $call->status = $json_call["status"];
                $call->duration = $json_call["duration"];
                $call->time = $json_call["time"] ?? 0;
                $call->save();
                
                if ($json_call["status"] == 1) {
                    foreach ($json_call["answers"] as $json_answer) {
                    $answer = new Answer();
                    $answer->call_id = $call->id;
                    $answer->faq_id = $json_answer["id"];
                    $answer->option_id = $json_answer["option_id"];
                    $answer->save();
                    }
                }
            }
        });
    }

    public function collect ($json, $file_name) {
        $this->status_id = 3;
        $this->reservation_file = $file_name;
        $this->save();

        $this->receive_result($json);

        Mail::to($this->survey->user->send_emails)->send(new ReservationCollected($this));
    }
}
