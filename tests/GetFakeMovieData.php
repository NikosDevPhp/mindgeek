<?php

namespace Tests;

trait GetFakeMovieData
{
    /**
     * A json of objects to test against
     * First document is valid, missing reviewAuthor, viewingWindow and others
     * Second document is valid, but duration is not numeric
     * @return mixed
     */
    private function getMovieArary()
    {
        $movies = '[{
    "body": "This controversial Austrian psychological chiller is a terrifying, persuasive and frighteningly in-your-face look at the escalating violence that can attack when you least expect it.\nIts vile story is brilliantly handled by its writer-director Michael Haneke, but no one can pretend it\'s an easy experience to watch.\nTwo pleasant-looking, credible young blokes (Arno Frisch, Frank Giering) turn up at the lavish lakeside home of a husband and wife holidaying with their young son, but it soon turns out the lads are evil itself and bit by bit they block every move of the couple to get rid of them. Then the real trouble begins.\nSince every detail about the film seems right, it all becomes far too close for comfort, even if it\'s set in far-away Austria and the director makes increasingly frequent \'it\'s only a movie flourishes.\nSuch clever film-making and performing at the service of a sick-making story leaves the audience very queasy indeed.",
    "cardImages": [
      {
        "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01.jpg",
        "h": 1004,
        "w": 768
      },
{
"url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01.jpg",
"h": 748,
"w": 1024
},
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01i-VPA-to-CP3.jpg",
        "h": 460,
        "w": 320
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01i-VPA-to-CP4.jpg",
        "h": 920,
        "w": 640
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01-LPA-to-LP3.jpg",
        "h": 300,
        "w": 480
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01-LPA-to-LP4.jpg",
        "h": 600,
        "w": 960
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-CW-01.jpg",
        "h": 720,
        "w": 1280
      }
],
"cast": [
      {
          "name": "Ulrich Mohe"
      },
      {
          "name": "Arno Frisch"
      },
      {
          "name": "Susanne Lothar"
      }
    ],
    "cert": "18",
    "class": "Movie",
    "directors": [
      {
          "name": "Michael Haneke"
      }
    ],
    "duration": 6540,
    "genres": [
    "Horror",
    "World Cinema"
],
    "headline": "Funny Games",
    "id": "8a3e88991ed140aa011ef3b328947ec5",
    "keyArtImages": [
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KP3.jpg",
        "h": 169,
        "w": 114
      },
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KP4.jpg",
        "h": 338,
        "w": 228
      },
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KPA.jpg",
        "h": 237,
        "w": 160
      }
    ],
    "lastUpdated": "2008-02-27",
    "quote": "no one can pretend it\'s an easy experience to watch",
    "rating": 3,
    "sum": "6da8f996a0c6536fa34a8b77cb43ba82",
    "synopsis": "This controversial Austrian psychological chiller is a terrifying, persuasive and frighteningly in-your-face look at the escalating violence that can attack when you least expect it. Two apparently decent fellows turn up at a family\'s lakeside home... and embark on a terrifying exercise in manipulation towards a very dark place. The vile story is brilliantly handled by writer-director Michael Haneke, but no one can pretend it\'s an easy experience to watch.",
    "url": "http://skymovies.sky.com/funny-games/review",
    "year": "1997"
  },
  {
    "body": "This controversial Austrian psychological chiller is a terrifying, persuasive and frighteningly in-your-face look at the escalating violence that can attack when you least expect it.\nIts vile story is brilliantly handled by its writer-director Michael Haneke, but no one can pretend it\'s an easy experience to watch.\nTwo pleasant-looking, credible young blokes (Arno Frisch, Frank Giering) turn up at the lavish lakeside home of a husband and wife holidaying with their young son, but it soon turns out the lads are evil itself and bit by bit they block every move of the couple to get rid of them. Then the real trouble begins.\nSince every detail about the film seems right, it all becomes far too close for comfort, even if it\'s set in far-away Austria and the director makes increasingly frequent \'it\'s only a movie flourishes.\nSuch clever film-making and performing at the service of a sick-making story leaves the audience very queasy indeed.",
    "cardImages": [
      {
        "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01.jpg",
        "h": 1004,
        "w": 768
      },
{
"url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01.jpg",
"h": 748,
"w": 1024
},
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01i-VPA-to-CP3.jpg",
        "h": 460,
        "w": 320
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-VPA-01i-VPA-to-CP4.jpg",
        "h": 920,
        "w": 640
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01-LPA-to-LP3.jpg",
        "h": 300,
        "w": 480
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-LPA-01-LPA-to-LP4.jpg",
        "h": 600,
        "w": 960
      },
{
    "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-CW-01.jpg",
        "h": 720,
        "w": 1280
      }
],
"cast": [
      {
          "name": "Ulrich Mohe"
      },
      {
          "name": "Arno Frisch"
      },
      {
          "name": "Susanne Lothar"
      }
    ],
    "cert": "18",
    "class": "Movie",
    "directors": [
      {
          "name": "Michael Haneke"
      }
    ],
    "duration": "asd6540",
    "genres": [
    "Horror",
    "World Cinema"
],
    "headline": "Funny Games",
    "id": "8a3e88991ed140aa011ef3b328947ec5",
    "keyArtImages": [
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KP3.jpg",
        "h": 169,
        "w": 114
      },
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KP4.jpg",
        "h": 338,
        "w": 228
      },
      {
          "url": "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/04/04/funny-games-1997-1S-KA-to-KPA.jpg",
        "h": 237,
        "w": 160
      }
    ],
    "lastUpdated": "2008-02-27",
    "quote": "no one can pretend it\'s an easy experience to watch",
    "rating": 3,
    "sum": "6da8f996a0c6536fa34a8b77cb43ba82",
    "synopsis": "This controversial Austrian psychological chiller is a terrifying, persuasive and frighteningly in-your-face look at the escalating violence that can attack when you least expect it. Two apparently decent fellows turn up at a family\'s lakeside home... and embark on a terrifying exercise in manipulation towards a very dark place. The vile story is brilliantly handled by writer-director Michael Haneke, but no one can pretend it\'s an easy experience to watch.",
    "url": "http://skymovies.sky.com/funny-games/review",
    "year": "1997"
  }]
  ';

        return json_decode($movies, true);
    }
}
