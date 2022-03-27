<?php

namespace App\Services;

use App\Models\Movie;
use App\Objects\CardImageDTO;
use App\Objects\CastDTO;
use App\Objects\DirectorDTO;
use App\Objects\GalleryDTO;
use App\Objects\GenreDTO;
use App\Objects\KeyArtImageDTO;
use App\Objects\MovieDTO;
use App\Objects\ViewingWindowDTO;
use App\Repositories\CastRepository;
use App\Repositories\DirectorRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ImageRepository;
use App\Repositories\MovieRepository;
use App\Utils\Helpers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieProviderService
{
    private const MOVIE_FEED_URL='https://mgtechtest.blob.core.windows.net/files/showcase.json';

    public function __construct(
        private MovieRepository    $movieRepo,
        private CastRepository     $castRepo,
        private DirectorRepository $directorRepo,
        private GenreRepository    $genreRepo,
        private ImageRepository    $imageRepo,
        private GalleryRepository  $galleryRepo
    ){}

    public function getMovies()
    {
        try {
            $response = Http::get(self::MOVIE_FEED_URL);
            $movies =  json_decode(Helpers::stringToUtf8($response->body()), true);

            foreach ($movies as $movie) {
                // keep only valid cardImages
                foreach ($movie['cardImages'] as $key => $image) {
                    $imageResponse = Http::get($image['url']);

                    if ($imageResponse->status() === 200) {
                        $uniqId = Helpers::generateUniqIdFromImageUrl($image['url']);
                        Storage::put($uniqId, $imageResponse->body());
                        $movie['cardImages'][$key]['path'] = $uniqId;
                    } else {
                        unset($movie['cardImages'][$key]);
                    }
                }

                // keep only valid keyArtImages
                foreach ($movie['keyArtImages'] as $key => $image) {
                    $imageResponse = Http::get($image['url']);

                    if ($imageResponse->status() === 200) {
                        $uniqId = Helpers::generateUniqIdFromImageUrl($image['url']);
                        Storage::put($uniqId, $imageResponse->body());
                        $movie['keyArtImages'][$key]['path'] = $uniqId;
                    } else {
                        unset($movie['keyArtImages'][$key]);
                    }
                }


                try {
//                    if ($key < 39) {
//                        continue;
//                    }


                    DB::beginTransaction();
                    $movieDTO = (new MovieDTO())->populateFromArray($movie);
                    $directors = (new DirectorDTO())->populateFromCollection($movie);
                    $cast = (new CastDTO())->populateFromCollection($movie);

                    $mov = $this->movieRepo->updateOrCreateByIdentifier($movieDTO, 'feedId');

                    $cas = $this->castRepo->updateOrCreateMultipleModelsByIdentifier($cast, 'name');
                    $this->castRepo->syncCollectionToModel($mov, 'casts', $cas);

                    $dir = $this->directorRepo->updateOrCreateMultipleModelsByIdentifier($directors, 'name');
                    $this->directorRepo->syncCollectionToModel($mov, 'directors', $dir);

                    $genreDTO = (new GenreDTO())->populateFromCollection($movie);
                    $gen = $this->genreRepo->updateOrCreateMultipleModelsByIdentifier($genreDTO, 'name');
                    $this->genreRepo->syncCollectionToModel($mov, 'genres', $gen);

                    $galleryDTO = (new GalleryDTO())->populateFromCollection($movie);
                    Helpers::addPropertyToCollectionOfObjects($galleryDTO, 'movie_id', $mov->id);


                    $gal = $this->galleryRepo->updateOrCreateMultipleModelsByIdentifier($galleryDTO, 'title');

                    $imageDTO = (new CardImageDTO())->populateFromCollection($movie)
                        ->merge((new KeyArtImageDTO())->populateFromCollection($movie));

                    Helpers::addPropertyToCollectionOfObjects($imageDTO, 'movie_id', $mov->id);


                    $img = $this->imageRepo->updateOrCreateMultipleModelsByIdentifier($imageDTO, 'url', ['movie_id' => $mov->id]);
                    DB::commit();
                    $x =5;
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    exit;
                    continue;
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    exit;
                }


//                if(isset($movie['videos'])) {
//                    foreach ($movie['videos'] as $video) {
//                        if (isset($video['url'])) {
//                            $videoResponse = Http::get($video['url']);
//                            if ($videoResponse->status() === 200) {
////                                Storage::put($movie['id'] . '_video_' . '.mp4', $videoResponse->body());
//                            }
//                        }
//
//                        if (isset($video['alternatives'])) {
//                            foreach ($video['alternatives'] as $alternative) {
//                                $videoResponse = Http::get($video['url']);
//                                if ($videoResponse->status() === 200) {
////                                    Storage::put($movie['id'] . '_video_alt_' . '.mp4', $videoResponse->body());
//                                }
//                            }
//                        }
//                    }
//                }

            }
            dd($movies);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function array_keys_multi(array $array)
    {
        $keys = array();

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys = array_merge($keys, $this->array_keys_multi($value));
            }
        }

        return $keys;
    }
}
