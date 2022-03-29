<?php

namespace Services;

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
use App\Services\MovieProviderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\FakeDTO;
use Tests\GetFakeMovieData;
use Tests\TestCase;

class MovieProviderServiceTest extends TestCase
{
    use GetFakeMovieData;

    public function testGetMoviesHappyPath()
    {
        // fakse http request, and storage
        Storage::fake('local');
        Http::fake(function ($request) {
            return Http::response('Error', 500);
        });

        // array only with first movie
        $movie = [$this->getMovieArray()[0]];
        // unset images should be handled by another test
        unset($movie[0]['cardImages']);
        unset($movie[0]['keyArtImages']);

        // mock eloquent model + getAttribute
        $mockedModel = Mockery::mock(Model::class);
        $mockedModel->shouldReceive('getAttribute')->andReturn(1)->getMock();

        // create a fakeDTO to accommodate for typed properties
        $baseDTO = app()->make(FakeDTO::class);
        $emptyCollection = collect();

        // Movie
        $mockMovieDTO = Mockery::mock('overload:' . MovieDTO::class)
            ->shouldReceive('populateFromArray')
            ->with($movie[0])
            ->andReturn($baseDTO)
            ->getMock();
        $this->app->instance(MovieDTO::class, $mockMovieDTO);

        $mockMovieRepo = Mockery::mock(MovieRepository::class)
            ->shouldReceive('updateOrCreateByIdentifier')
            ->withArgs([$baseDTO, 'feedId'])
            ->andReturn($mockedModel)
            ->getMock();
        $this->app->instance(MovieRepository::class, $mockMovieRepo);

        // Director
        $mockDirectorDTO = Mockery::mock('overload:' . DirectorDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(DirectorDTO::class, $mockDirectorDTO);

        $mockDirectorRepo = Mockery::mock(DirectorRepository::class)
            ->shouldReceive('updateOrCreateMultipleModelsByIdentifier')
            ->withArgs([$emptyCollection, 'name'])
            ->andReturn($emptyCollection)
            ->getMock()
            ->shouldReceive('syncCollectionToModel')
            ->withArgs([$mockedModel, 'directors', $emptyCollection])
            ->getMock();
        $this->app->instance(DirectorRepository::class, $mockDirectorRepo);

        // Cast
        $mockCastDTO = Mockery::mock('overload:' . CastDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(CastDTO::class, $mockCastDTO);

        $mockCastRepo = Mockery::mock(CastRepository::class)
            ->shouldReceive('updateOrCreateMultipleModelsByIdentifier')
            ->withArgs([$emptyCollection, 'name'])
            ->andReturn($emptyCollection)
            ->getMock()
            ->shouldReceive('syncCollectionToModel')
            ->withArgs([$mockedModel, 'casts', $emptyCollection])
            ->getMock();
        $this->app->instance(CastRepository::class, $mockCastRepo);

        // Genres
        $mockGenreDTO = Mockery::mock('overload:' . GenreDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(GenreDTO::class, $mockGenreDTO);

        $mockGenreRepo = Mockery::mock(GenreRepository::class)
            ->shouldReceive('updateOrCreateMultipleModelsByIdentifier')
            ->withArgs([$emptyCollection, 'name'])
            ->andReturn($emptyCollection)
            ->getMock()
            ->shouldReceive('syncCollectionToModel')
            ->withArgs([$mockedModel, 'genres', $emptyCollection])
            ->getMock();
        $this->app->instance(GenreRepository::class, $mockGenreRepo);

        // Gallery
        $mockGalleryDTO = Mockery::mock('overload:' . GalleryDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(GalleryDTO::class, $mockGalleryDTO);

        $mockGalleryRepo = Mockery::mock(GalleryRepository::class)
            ->shouldReceive('deleteByFilters')
            ->getMock()
            ->shouldReceive('updateOrCreateMultipleModelsByIdentifier')
            ->getMock();
        $this->app->instance(GalleryRepository::class, $mockGalleryRepo);

        // Images
        $cardImageDTO = Mockery::mock('overload:' . CardImageDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(CardImageDTO::class, $cardImageDTO);

        $keyArtImageDTO = Mockery::mock('overload:' . KeyArtImageDTO::class)
            ->shouldReceive('populateFromCollection')
            ->with($movie[0])
            ->andReturn($emptyCollection)
            ->getMock();
        $this->app->instance(KeyArtImageDTO::class, $keyArtImageDTO);

        $mockImageRepo = Mockery::mock(ImageRepository::class)
            ->shouldReceive('deleteByFilters')
            ->getMock()
            ->shouldReceive('updateOrCreateMultipleModelsByIdentifier')
            ->getMock();
        $this->app->instance(ImageRepository::class, $mockImageRepo);


        $service = app()->make(MovieProviderService::class);
        $result = $service->getMovies(json_encode($movie));

        $this->assertTrue($result);
    }

    // TODO: add more test cases

}
