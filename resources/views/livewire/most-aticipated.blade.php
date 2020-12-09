<div>
    <div wire:init="loadMostAticipated" class="recently-reviewed-container space-y-12 mt-8">
        @forelse($mostAnticipated as $game)
                    <x-game-card-small :game="$game" />
                    @empty
                    @foreach(range(1,3) as $item)
                    <div class="game flex">
            <div class="w-20 h-20 bg-gray-700 rounded shadow-md">

            </div>
            <div class="ml-8">
                <div class="inline-block bg-gray-700 p-2 shadow-md rounded text-transparent"> dolor sit, ametitecto, ipsam?</div>
                <div class="inline-block bg-gray-700 p-1 shadow-md rounded text-transparent mt-1"> 12/04/2001 </div>
            </div>
        </div>
        @endforeach
                    @endforelse
       
    </div>
</div>