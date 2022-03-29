<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ecommerce Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    {{--  TODO: js, css refactor to resources  --}}
    <!-- Css Styles -->
    <link rel="stylesheet" href="/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/style.css" type="text/css">



    <!-- Template Main JS File -->
    <script src="/bootstrap.min.js"></script>
    <script src="/mixitup.min.js"></script>
    <script src="/main.js"></script>
</head>
<body>

<section class="featured spad">
    <div class="container">
        <div class="row featured__filter">
            @if(isset($movie->images))
                @foreach($movie->images as $image)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix">
                        <div class="featured__item">
                            <img src="{{Storage::url($image->path)}}" alt="Image" class="img-fluid" style="object-fit: cover; width: 500px; height: 500px">
                            <div class="featured__item__pic set-bg" data-setbg="">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="assets/img/banner/banner-1.jpg" alt="" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="assets/img/banner/banner-2.jpg" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>


<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>Details</h2>
                </div>
            </div>
        </div>
        @if(isset($movie->body))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Body</a></h5>
                        <p>{{$movie->body}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->casts))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Cast</a></h5>
                        <p>{{implode(',', $movie->casts->pluck('name')->all())}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->directors))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Directors</a></h5>
                        <p>{{implode(',', $movie->directors->pluck('name')->all())}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->genres))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Genres</a></h5>
                        <p>{{implode(',', $movie->genres->pluck('name')->all())}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->gallery))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Gallery</a></h5>
                        <p>{{$movie->gallery->title}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->cert))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Certificate</a></h5>
                        <p>{{$movie->cert}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->class))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Class</a></h5>
                        <p>{{$movie->class}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->duration))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Duration</a></h5>
                        <p>{{$movie->duration / 60 }} minutes</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->headline))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Headline</a></h5>
                        <p>{{$movie->headline}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->quote))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Quote</a></h5>
                        <p>{{$movie->quote}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->lastUpdated))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Last updated</a></h5>
                        <p>{{$movie->lastUpdated}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->rating))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Rating</a></h5>
                        <p>{{$movie->rating}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->reviewAuthor))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Review Author</a></h5>
                        <p>{{$movie->reviewAuthor}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->year))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Year</a></h5>
                        <p>{{$movie->year}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->viewingTitle))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Viewing Title</a></h5>
                        <p>{{$movie->viewingTitle}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->viewingStartDate))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Viewing Start Date</a></h5>
                        <p>{{$movie->viewingStartDate}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->viewingEndDate))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Viewing End Date</a></h5>
                        <p>{{$movie->viewingEndDate}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($movie->viewingWayToWatch))
            <div class="row">
                <div class="blog__item">
                    <div class="blog__item__text">
                        <h5><a href="#">Viewing Way To Watch</a></h5>
                        <p>{{$movie->viewingWayToWatch}}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<footer class="footer spad">
    <div class="container">
        <div class="row">

        </div>
    </div>
</footer>

</body>
</html>
