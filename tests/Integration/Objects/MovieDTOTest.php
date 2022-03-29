<?php

namespace Tests\Integration\Objects;

use App\Objects\MovieDTO;
use Illuminate\Support\Facades\Log;
use ReflectionProperty;
use Tests\GetFakeMovieData;
use Tests\TestCase;

class MovieDTOTest extends TestCase
{

    use GetFakeMovieData;

    public function testPopulateFromArrayHappyPath()
    {
        /** @see GetFakeMovieData::getMovieArary() */
        $data = $this->getMovieArary()[0];
        $movieDTO = app()->make(MovieDTO::class);
        $movieDTO = $movieDTO->populateFromArray($data);

        $this->assertEquals($data['body'], $movieDTO->body);
        $this->assertEquals($data['cert'], $movieDTO->cert);
        $this->assertEquals($data['class'], $movieDTO->class);
        $this->assertEquals($data['duration'], $movieDTO->duration);
        $this->assertEquals($data['headline'], $movieDTO->headline);
        $this->assertEquals($data['id'], $movieDTO->feedId);
        $this->assertEquals($data['lastUpdated'], $movieDTO->lastUpdated);
        $this->assertEquals($data['quote'], $movieDTO->quote);
        $this->assertEquals($data['rating'], $movieDTO->rating);
        $this->assertEquals($data['year'], $movieDTO->year);

        $p = new ReflectionProperty($movieDTO, 'reviewAuthor');
        $this->assertFalse($p->isInitialized($movieDTO));

    }

    public function testPopulateFromArrayInvalidData()
    {
        /** @see GetFakeMovieData::getMovieArary() */
        $data = $this->getMovieArary()[1];
        $movieDTO = app()->make(MovieDTO::class);

        Log::shouldReceive('error')
            ->with('Invalid data provided for field duration' );

        $movieDTO = $movieDTO->populateFromArray($data);

        $this->assertEquals($data['body'], $movieDTO->body);
        $this->assertEquals($data['cert'], $movieDTO->cert);
        $this->assertEquals($data['class'], $movieDTO->class);
        $this->assertEquals($data['headline'], $movieDTO->headline);
        $this->assertEquals($data['id'], $movieDTO->feedId);
        $this->assertEquals($data['lastUpdated'], $movieDTO->lastUpdated);
        $this->assertEquals($data['quote'], $movieDTO->quote);
        $this->assertEquals($data['rating'], $movieDTO->rating);
        $this->assertEquals($data['year'], $movieDTO->year);

        $p = new ReflectionProperty($movieDTO, 'duration');
        $this->assertFalse($p->isInitialized($movieDTO));
    }

}
