<?php

namespace App\Services;

use App\Console\Commands\SyncMoviesCommand;
use App\Objects\CardImageDTO;
use App\Objects\CastDTO;
use App\Objects\DirectorDTO;
use App\Objects\GalleryDTO;
use App\Objects\GenreDTO;
use App\Objects\KeyArtImageDTO;
use App\Objects\MovieDTO;
use App\Repositories\CastRepository;
use App\Repositories\DirectorRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\GenreRepository;
use App\Repositories\ImageRepository;
use App\Repositories\MovieRepository;
use App\Utils\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MovieProviderService
{
    public function __construct(
        private MovieRepository    $movieRepo,
        private CastRepository     $castRepo,
        private DirectorRepository $directorRepo,
        private GenreRepository    $genreRepo,
        private ImageRepository    $imageRepo,
        private GalleryRepository  $galleryRepo
    ){}

    /**
     * Given a json string with movies will populate/sync db tables with available data
     * @param string $json
     * @return bool
     * @throws Throwable
     * @see SyncMoviesCommand::MOVIE_FEED_URL for json string
     */
    public function getMovies(string $json): bool
    {
        try {
            $movies =  json_decode(Helpers::stringToUtf8($json), true);

            foreach ($movies as $movie) {
                // keep only valid cardImages
                if(isset($movie['cardImages']) && is_array($movie['cardImages'])) {
                    foreach ($movie['cardImages'] as $key => $image) {
                        $imageResponse = Http::get($image['url']);

                        if ($imageResponse->status() === 200) {
                            $uniqId = Helpers::generateUniqIdFromImageUrl($image['url']);
                            Storage::put('public/' . $uniqId, $imageResponse->body());
                            $movie['cardImages'][$key]['path'] = $uniqId;
                        } else {
                            unset($movie['cardImages'][$key]);
                        }
                    }
                }


                // keep only valid keyArtImages
                if (isset($movie['keyArtImages']) && is_array($movie['keyArtImages'])) {
                    foreach ($movie['keyArtImages'] as $key => $image) {
                        $imageResponse = Http::get($image['url']);

                        if ($imageResponse->status() === 200) {
                            $uniqId = Helpers::generateUniqIdFromImageUrl($image['url']);
                            Storage::put('public/' .$uniqId, $imageResponse->body());
                            $movie['keyArtImages'][$key]['path'] = $uniqId;
                        } else {
                            unset($movie['keyArtImages'][$key]);
                        }
                    }
                }

                // remove 'Gallery:' from start of string
                if (isset($movie['galleries']['title']) && is_string($movie['galleries']['title'])) {
                    $movie['galleries']['title'] = Helpers::removeKeywordFromString(
                        $movie['galleries']['title'],
                        'Gallery:'
                    );
                }
                // TODO: get also videos from feed with the same logic
                try {

                    DB::beginTransaction();
                    // 1. update movie
                    $movieDTO = (new MovieDTO())->populateFromArray($movie);
                    $movieModel = $this->movieRepo->updateOrCreateByIdentifier($movieDTO, 'feedId');

                    // 2. sync directors
                    $directorsDTO = (new DirectorDTO())->populateFromCollection($movie);
                    $directorsCollection = $this->directorRepo->updateOrCreateMultipleModelsByIdentifier($directorsDTO, 'name');
                    $this->directorRepo->syncCollectionToModel($movieModel, 'directors', $directorsCollection);

                    // 3. sync cast
                    $castDTO = (new CastDTO())->populateFromCollection($movie);
                    $castCollection = $this->castRepo->updateOrCreateMultipleModelsByIdentifier($castDTO, 'name');
                    $this->castRepo->syncCollectionToModel($movieModel, 'casts', $castCollection);

                    // 4. sync genres
                    $genreDTO = (new GenreDTO())->populateFromCollection($movie);
                    $genreCollection = $this->genreRepo->updateOrCreateMultipleModelsByIdentifier($genreDTO, 'name');
                    $this->genreRepo->syncCollectionToModel($movieModel, 'genres', $genreCollection);

                    // 5. sync gallery - manually add movie_id to collection
                    $galleryDTO = (new GalleryDTO())->populateFromCollection($movie);
                    Helpers::addPropertyToCollectionOfObjects($galleryDTO, 'movie_id', $movieModel->id);
                    // manually sync one to many relationship
                    $this->galleryRepo->deleteByFilters([['movie_id', '=',  $movieModel->id]]);
                    $this->galleryRepo->updateOrCreateMultipleModelsByIdentifier($galleryDTO, 'title');

                    // 6. sync images - manually add movie_id to collection
                    $imageDTO = (new CardImageDTO())->populateFromCollection($movie)
                        ->merge((new KeyArtImageDTO())->populateFromCollection($movie));
                    Helpers::addPropertyToCollectionOfObjects($imageDTO, 'movie_id', $movieModel->id);
                    $this->imageRepo->deleteByFilters([['movie_id', '=',  $movieModel->id]]);
                    $this->imageRepo->updateOrCreateMultipleModelsByIdentifier($imageDTO, 'url', ['movie_id' => $movieModel->id]);

                    DB::commit();
                } catch (\Exception | Throwable $e) {
                    DB::rollBack();
                    Log::error($e);
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
        return true;
    }
}
