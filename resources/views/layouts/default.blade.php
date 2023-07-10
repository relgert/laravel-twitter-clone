<!doctype html>

<html>

<head>
    @livewireStyles
    @include('includes.head')
</head>

<body>
    @include('partials.nav')
    <div >

        <header class="row">



        </header>

        <div id="main" class="row">

            @yield('content')

        </div>

    </div>
    @livewireScripts
</body>

</html>
