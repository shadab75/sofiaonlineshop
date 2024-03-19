<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/images/home/Logo.gif')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/images/home/Logo.gif')}}">
    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
    @yield('style')
    {!! SEO::generate() !!}

</head>

<body>

{{-- @yield('content') --}}

<div class="wrapper">
    <div id="preloader">
        <div id="box"></div>
    </div>

    @include('home.sections.header')

    @include('home.sections.mobile_off_canvas')

    @yield('content')

    @include('home.sections.footer')



</div>


<!-- JavaScript-->
<script src="{{ asset('/js/home/jquery-1.12.4.min.js') }}"></script>

<script src="{{ asset('/js/home/plugins.js') }}"></script>
<script src="{{ asset('/js/home.js') }}"></script>


@include('sweet::alert')

@yield('script')
<script>
    $('#userSearch-input').keyup(function (event){
        let search = $('#userSearch-input').val();
        $('#userFilter-search').val(search)
        if (event.key==="Enter")
        {
            event.preventDefault();
            $('#search-form').submit();
        }
    })
    function search()
    {
        let search = $('#userSearch-input').val();
        $('#userFilter-search').val(search);
        $('#search-form').submit()
    }


</script>

<script>
    $('#mbuserSearch-input').keyup(function (event){
        let search = $('#mbuserSearch-input').val();
        $('#mbuserFilter-search').val(search)
        if (event.key==="Enter")
        {
            event.preventDefault();
            $('#mbsearch-form').submit();
        }
    })
    function mbsearch()
    {
        let search = $('#mbuserSearch-input').val();
        $('#mbuserFilter-search').val(search);
        $('#mbsearch-form').submit()
    }


</script>

<script>
    window.onload = function () {
        setTimeout(hidePreloader,1000);
        //hidePreloader();
    };
    function hidePreloader(){
        document.getElementById('preloader').setAttribute('class','hide');
    }
</script>
</body>


</html>
