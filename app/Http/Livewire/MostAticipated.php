<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MostAticipated extends Component

{
    public $mostAnticipated=[];
    public function loadMostAticipated(){
        $afterfourmonth = Carbon::now()->addMonths(4)->timestamp;
        $current= Carbon::now()->timestamp;
        $this->mostAnticipated = Cache::remember('most-aticipated', 5, function () use ($current,$afterfourmonth) {
            return Http::withHeaders([
                'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
                'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
            ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating, rating_count, summary,slug;
                where platforms = (48,49,130,6) & slug != null & cover.url != null & rating != null & videos !=null 
                & (first_release_date >= {$current}
                & first_release_date < {$afterfourmonth});
                sort popularity desc;
                limit 4;",
                "text/plain"
            )->post('https://api.igdb.com/v4/games/', [])->json();
        });
    }
    public function render()
    {
        return view('livewire.most-aticipated');
    }
}
