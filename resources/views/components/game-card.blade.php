<div class="game mt-8">
    <div class="relative inline-block">
        <a href="{{ route('games.show', $game['slug']) }}">
            <img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
        </a>
        @if ($game['rating'])
            <div id="{{Str::studly($game['slug'])}}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right: -20px; bottom: -20px">          
            </div>
        @endif
    </div>
    <a href="{{ route('games.show', $game['slug']) }}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">{{ $game['name'] }}</a>
    <div class="text-gray-400 mt-1">
    @foreach($game['platforms'] as $item1)
                @if(array_key_exists('abbreviation',$item1))
                {{$item1['abbreviation']}}
                &middot;
                @endif
                @endforeach
    </div>
</div>
