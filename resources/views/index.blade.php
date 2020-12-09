@extends('layouts.app')
@section('content')
<div class="container px-4 mx-auto">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
    <livewire:popular-games>
        <div class="flex flex-col lg:flex-row my-10">
            <div class="recently-reviewed w-full mr-0 lg:mr-32 lg:w-3/4">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">recently reviewed</h2>

                <livewire:recently-reviewed  wire:click="$emit('postAdded',2)">
            </div>
            <div class="most-aticipated w-full lg:w-1/4 mt-8 lg:mt-0">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">most aticipated</h2>
                <livewire:most-aticipated>
            </div>
        </div>
        @endsection