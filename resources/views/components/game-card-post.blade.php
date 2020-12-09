<div class="game bg-gray-800 shadow-md rounded-lg flex px-6 py-4">
            <div class="relative flex-none">
                <a href="{{ route('games.show', $game['slug'])}}"><img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}" class="w-48 hover:opacity-75 transition ease-in-out duration-150 my-2" alt=""></a>
            </div>
            <div class="absolute">
                <div class="absolute rounded-full top-56 left-40 w-14 h-14 bg-gray-900">
                    <div id="{{$game['slug']}}" class="font-semibold text-xs flex justify-center h-full items-center relative">
                    </div>
                </div>
            </div>
            <div class="ml-8">
                <a href="{{ route('games.show', $game['slug'])}}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8 flex items-center">{{$game['name']}}</a>
                <div class="text-gray-400 mt-1">@foreach($game['platforms'] as $item1)
                    @if(array_key_exists('abbreviation',$item1))
                    {{$item1['abbreviation']}},
                    @endif
                    @endforeach</div>
                <div class="text-gray-400 mt-6 hidden sm:block">{{$game['summary']}}</div>
            </div>
        </div>