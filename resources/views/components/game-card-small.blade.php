<div class="game flex">
                        <a class="flex-none" href="{{ route('games.show', $game['slug'])}}">
                            <img src="{{Str::replaceFirst('thumb','cover_big',$game['cover']['url'])}}" alt="" class="w-16 h-16 hover:opacity-75 ease-in-out duration-150">
                        </a>
                        <div class="ml-8 ">
                            <a href="{{ route('games.show', $game['slug'])}}">
                                <div class="hover:text-gray-300">{{$game['name']}}</div>
                            </a>
                            <div class="text-gray-500 mt-4">{{Carbon\Carbon::parse($game['first_release_date'])->format('M d, Y')}}</div>
                        </div>
                    </div>