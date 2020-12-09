<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;
class PopularGames extends Component
{
    public $popular_games = [];
    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;

        $after = Carbon::now()->addMonths(2)->timestamp;
        $this->popular_games = Cache::remember('popular-games', 1, function () use ($before, $after) {
            return Http::withHeaders([
                'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
                'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
            ])->withBody(
                "fields cover.url, name,first_release_date,rating_count,platforms.abbreviation,rating,slug;
                
                  where platforms = (48,49,130,6) & videos !=null & cover.url !=null & (first_release_date > {$before} & first_release_date < {$after}& rating_count > 3);
                  sort total_rating_count desc;
                  limit 12;",
                "text/plain"
            )->post('https://api.igdb.com/v4/games/', [])->json();
        });
        collect($this->popular_games)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gamewithRatingAdded', [
                'slug'=>Str::studly($game['slug']),
                'rating'=>$game['rating']/100,
            ]);
        });

    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
