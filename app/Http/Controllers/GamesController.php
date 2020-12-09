<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GamesController extends Controller
{
    //
    public function index()
    {
        sleep(1);
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;
        $afterfourmonth = Carbon::now()->addMonths(4)->timestamp;
        $current= Carbon::now()->timestamp;
        
        // $popular_games = Cache::remember('popular-games', 1, function () use ($before, $after) {
        //     return Http::withHeaders([
        //         'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
        //         'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
        //     ])->withBody(
        //         "fields cover.url, name,first_release_date,rating_count,platforms.abbreviation,rating,slug;
            
        //       where platforms = (48,49,130,6) & videos !=null & cover.url !=null & (first_release_date > {$before} & first_release_date < {$after}& rating_count > 3);
        //       sort total_rating_count desc;
        //       limit 12;",
        //         "text/plain"
        //     )->post('https://api.igdb.com/v4/games/', [])->json();
        // });
        // $recently_reviewed = Cache::remember('recently-reviewed', 1, function () use ($before,$current) {
        //     return Http::withHeaders([
        //         'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
        //         'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
        //     ])->withBody(
        //         "fields name,cover.url,first_release_date,rating_count,summary,platforms.abbreviation,rating,slug;
        //        where platforms = (48,49,130,6) & videos !=null & cover.url !=null & (first_release_date > {$before} & first_release_date < {$current} & rating_count > 5);
        //        sort total_rating_count desc;
        //        limit 5;",
        //         "text/plain"
        //     )->post('https://api.igdb.com/v4/games/', [])->json();
        // });
        // $mostAnticipated = Cache::remember('most-aticipated', 1, function () use ($current,$afterfourmonth) {
        //     return Http::withHeaders([
        //         'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
        //         'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
        //     ])->withBody(
        //         "fields name, cover.url, first_release_date, platforms.abbreviation, rating, rating_count, summary,slug;
        //         where platforms = (48,49,130,6) & slug != null & cover.url != null & rating != null & videos !=null 
        //         & (first_release_date >= {$current}
        //         & first_release_date < {$afterfourmonth});
        //         sort popularity desc;
        //         limit 4;",
        //         "text/plain"
        //     )->post('https://api.igdb.com/v4/games/', [])->json();
        // });
        return view('index', [
            // 'popular_games' => $popular_games,
            // 'recently_reviewed' => $recently_reviewed,
            // 'mostAnticipated' => $mostAnticipated
        ]);
    }
    
    public function show($slug)
    {
        $game = Cache::remember('popular_games', 1, function () use ($slug) {
            return Http::withHeaders([
                'Client-ID' => 'tcfhk410jvedxjssammp19ioqtxpls',
                'Authorization' => 'Bearer lk3xopy3zbhshcllwq28zgaroqgh8e'
            ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating,rating_count,
                slug, involved_companies.company.name, genres.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating,similar_games.platforms.abbreviation, similar_games.slug;
                where slug=\"{$slug}\";",
                "text/plain"
            )->post('https://api.igdb.com/v4/games/', [])->json();

        });
        if(isset($game[0]['similar_games'])){
            $similarGames=collect($game[0]['similar_games'])->map(function ($game1) {
                return collect($game1)->merge([
                    'coverImageUrl' => array_key_exists('cover', $game1)
                        ? Str::replaceFirst('thumb', 'cover_big', $game1['cover']['url'])
                        : 'https://via.placeholder.com/264x352',
                    'rating' => isset($game1['rating']) ? round($game1['rating']) : 0,
                    'platforms' => array_key_exists('platforms', $game1)
                        ? collect($game1['platforms'])->pluck('abbreviation')->implode('-')
                        : null,
                ]);
            })->take(12);
        }
        else{
            $similarGames=null;
        }
        abort_if(!$game, 404);
        return view('show', [
            'game' => $game[0],
            'similarGames' => $similarGames,
        ]);
    }
    private function formatGameForView($game)
    {
        return collect($game)->merge([
            'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
            'genres' => collect($game['genres'])->pluck('name')->implode(', '),
            'involvedCompanies' => $game['involved_companies'][0]['company']['name'],
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'memberRating' => array_key_exists('rating', $game) ? round($game['rating']) : '0',
            'criticRating' => array_key_exists('aggregated_rating', $game) ? round($game['aggregated_rating']) : '0',
            'trailer' => 'https://youtube.com/embed/'.$game['videos'][0]['video_id'],
            'screenshots' => collect($game['screenshots'])->map(function ($screenshot) {
                return [
                    'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                    'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']),
                ];
            })->take(9),
            'similarGames' => collect($game['similar_games'])->map(function ($game) {
                return collect($game)->merge([
                    'coverImageUrl' => array_key_exists('cover', $game)
                        ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                        : 'https://via.placeholder.com/264x352',
                    'rating' => isset($game['rating']) ? round($game['rating']) : null,
                    'platforms' => array_key_exists('platforms', $game)
                        ? collect($game['platforms'])->pluck('abbreviation')->implode(', ')
                        : null,
                ]);
            })->take(6),
            'social' => [
                'website' => collect($game['websites'])->first(),
                'facebook' => collect($game['websites'])->filter(function ($website) {
                    return Str::contains($website['url'], 'facebook');
                })->first(),
                'twitter' => collect($game['websites'])->filter(function ($website) {
                    return Str::contains($website['url'], 'twitter');
                })->first(),
                'instagram' => collect($game['websites'])->filter(function ($website) {
                    return Str::contains($website['url'], 'instagram');
                })->first(),
            ]
        ]);
    }
}
