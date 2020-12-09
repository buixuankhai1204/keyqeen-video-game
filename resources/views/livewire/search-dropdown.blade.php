<div class="realative" x-data="{isVisible: true}"@click.away="isVisible=false">
    <input
     wire:model.debounce.100ms="search" 
     @focus="isVisible=true" 
     x-ref="search"
     @keydown.window="if(event.keyCode===191){
         event.preventDefault();
         $refs.search.focus();
     }"
     @keydown.escape.window="isVisible= false" 
     @keydown="isVisible=true" type="text" class="rounded-full bg-gray-800 px-3 pl-8 py-1 w-64 text-sm focus:outline-none focus:shadow-outline" placeholder="press '/' to search">
    <div class="absolute flex top-10 hidden lg:block items-center ml-2">
        <svg class="fill-current w-4 text-gray-400 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 487.95 487.95" style="enable-background:new 0 0 487.95 487.95;" xml:space="preserve">
            <g>
                <path d="M481.8,453l-140-140.1c27.6-33.1,44.2-75.4,44.2-121.6C386,85.9,299.5,0.2,193.1,0.2S0,86,0,191.4s86.5,191.1,192.9,191.1    c45.2,0,86.8-15.5,119.8-41.4l140.5,140.5c8.2,8.2,20.4,8.2,28.6,0C490,473.4,490,461.2,481.8,453z M41,191.4    c0-82.8,68.2-150.1,151.9-150.1s151.9,67.3,151.9,150.1s-68.2,150.1-151.9,150.1S41,274.1,41,191.4z" />
            </g>
        </svg>
    </div>
    <div wire:loading class="spinner top-12 right-24" style="position: absolute;"></div>
    @if(strlen($search)>2)
    <div class="absolute z-50 text-ts bg-gray-800 w-64 mt-2"x-show.transition.opacity.duration.500="isVisible">
            @if(count($searchResult)>0)
        <ul>
            @foreach($searchResult as $game)
            <li class="border border-gray-700 rounded-md">
                <a href="{{ route('games.show', $game['slug'])}}" class="block hover:bg-gray-500 flex items-center ease-in-out duration-150 transition px-3 py-2">
                @if(isset($game['cover']))   
                <img src="{{Str::replaceFirst('thumb','cover_small',$game['cover']['url'])}}" alt="">
                @else
                <img src="https://via.placeholder.com/90x65" alt="">
                @endif
                    <span class="ml-4">{{$game['name']}}</span>
                </a>

            </li>
            
            @endforeach
        </ul>
        @else
            <p class="rounded-md px-3 py-1 bg-gray-700">no game</p>
            @endif
    </div>
    @endif
</div>