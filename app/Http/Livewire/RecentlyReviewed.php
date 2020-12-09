<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;
class RecentlyReviewed extends Component
{
    public $recently_reviewed=[];
    public function loadRecentlyReviewed(){
        $before = Carbon::now()->subMonths(2)->timestamp;
        
        $current= Carbon::now()->timestamp;
        $this->recently_reviewed = Cache::remember('recently-reviewed', 1, function () use ($before,$current) {
            return Http::withHeaders([
                'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
                'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
            ])->withBody(
                "fields name,cover.url,first_release_date,rating_count,summary,platforms.abbreviation,rating,slug;
               where platforms = (48,49,130,6) & videos !=null & cover.url !=null & (first_release_date > {$before} & first_release_date < {$current} & rating_count > 5);
               sort total_rating_count desc;
               limit 5;",
                "text/plain"
            )->post('https://api.igdb.com/v4/games/', [])->json();
        });
        collect($this->recently_reviewed)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('recentlygameWithRatingAdded', [
                'slug'=>$game['slug'],
                'rating'=>$game['rating']/100,
            ]);
        });
    }
    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
