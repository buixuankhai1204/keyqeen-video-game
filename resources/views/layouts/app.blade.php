<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<title>keyqeen Video Games</title>
<livewire:styles />

</head>

<body class="bg-gray-900 text-white">
    <header class="border-b border-gray-800">
        <nav class=" container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
            <div class="flex items-center flex-col lg:flex-row">
                <a href="{{route('home')}}"><img src="{{asset('public/images/logo.jpeg')}}" alt="laracast" class="w-32 flex-none"></a>
                <ul class="flex ml-16  space-x-6 my-4">
                    <li><a class="hover:text-gray-400" href="{{route('home')}}">Game</a></li>
                    <li><a class="hover:text-gray-400" href="/">Reviews</a></li>
                    <li><a class="hover:text-gray-400" href="/">Comming Son</a></li>
                </ul>
            </div>
            <div class="flex items-center mb-2">
                <livewire:search-dropdown>
                <div><img class="ml-6 rounded-full w-8" src="{{asset('public/images/avatar.jpg')}}" alt=""></div>
            </div>
        </nav>
    </header>
    <main class="py-8">
        @yield('content')
    </main>
    <footer class="border-t border-gray-800">
    <div class="container mx-auto px-4 py-6">
        powere By <a href="" class="hover:text-gray-400">IGBD API</a>
    </div>
    </footer>
    <livewire:scripts />
    <script src="{{asset('public/js/app.js')}}"></script>
    @stack('scripts')
    @stack('scripts1')
    @stack('scripts2')
</body>

</html>