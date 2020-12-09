<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResult = [];
    public function render()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;

        $after = Carbon::now()->addMonths(2)->timestamp;
        $this->searchResult = Cache::remember('popular-games', 1, function () use ($before, $after) {
            return Http::withHeaders([
                'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
                'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
            ])->withBody(
                "search \"{$this->search}\";
                fields name, slug, cover.url;
                limit 8;",
                "text/plain"
            )->post('https://api.igdb.com/v4/games/', [])->json();
        });
        return view('livewire.search-dropdown');
    }
}
