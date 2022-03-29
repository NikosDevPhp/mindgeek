<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindgeek</title>
    {{--  TODO: js, css refactor to resources  --}}
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="all.min.css">
    <link rel="stylesheet" href="templatemo-style.css">
</head>
<body>
<!-- Page Loader -->
<div id="loader-wrapper">
    <div id="loader"></div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

</div>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            MindGeek Movies
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>

<div class="container-fluid tm-container-content tm-mt-60">
    <div class="row mb-4">
        <h2 class="col-6 tm-text-primary">
            All Movies
        </h2>
    </div>


    <div class="row tm-mb-90 tm-gallery">
        @foreach($movies as $movie)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="{{Storage::url($movie->images->first()->path)}}" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>{{$movie->headline}}</h2>
                        <a href="{{route('getMovie', $movie->id)}}">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-dark">{{$movie->lastUpdated}}</span>
                    <span class="tm-text-gray-dark">Rating: {{$movie->rating}}</span>
                </div>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-dark">{{$movie->quote ?? ''}}</span>
                </div>
            </div>
        @endforeach


    </div> <!-- row -->
{{--    <div class="row tm-mb-90">--}}
{{--        <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">--}}
{{--            <a href="javascript:void(0);" class="btn btn-primary tm-btn-prev mb-2 disabled">Previous</a>--}}
{{--            <div class="tm-paging d-flex">--}}
{{--                <a href="javascript:void(0);" class="active tm-paging-link">1</a>--}}
{{--                <a href="javascript:void(0);" class="tm-paging-link">2</a>--}}
{{--                <a href="javascript:void(0);" class="tm-paging-link">3</a>--}}
{{--                <a href="javascript:void(0);" class="tm-paging-link">4</a>--}}
{{--            </div>--}}
{{--            <a href="javascript:void(0);" class="btn btn-primary tm-btn-next">Next Page</a>--}}
{{--        </div>--}}
{{--    </div>--}}
</div> <!-- container-fluid, tm-container-content -->

<footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                Copyright 2020 Mindgeek. All rights reserved.
            </div>
        </div>
    </div>
</footer>

<script src="plugins.js"></script>
<script>
    $(window).on("load", function() {
        $('body').addClass('loaded');
    });
</script>
</body>
</html>
