<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 12/20/2016
 * Time: 6:56 PM
 */
?>

        <!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<title>IT Glance Forum</title>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> {{-- imp to make responsive--}}
    <title>{{ trans('front/site.title') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{--imp to make responsive--}}
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/mdb.css" rel="stylesheet">
    <link href="/css/mdb.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/compiled.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">


    @yield('head')

</head>
<body style="background-color: ghostwhite">
<!--Navbar-->


@include('navs')

<!--/.Navbar-->

<div class="container">
    @yield('contents')
</div>

<script src="/jquery/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/mdb.min.js"></script>
<script src="/tinymce/tinymce.min.js"></script>
<script src="/js/tether.min.js"></script>
<script src="/js/compiled.min.js"></script>
{{--<script src="/tinymce/jquery.tinymce.min.js"></script>--}}



@yield('script')
</body>
</html>

