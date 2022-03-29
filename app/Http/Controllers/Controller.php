<?php

namespace App\Http\Controllers;

use App\Repositories\MovieRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(public MovieRepository $movieRepo){}

    public function index()
    {
        $movies = $this->movieRepo->getMultipleModelsWithRelations(['images']);
        return view('welcome', compact('movies'));
    }

    public function get($id)
    {
        // TODO: refactor this to a scopeWithAll query
        $movie = $this->movieRepo->getModelWithRelations(
            'id',
            $id,
            ['casts', 'directors', 'genres', 'gallery', 'cardImages', 'keyArtImages']
        )->first();
        return view('details', compact('movie'));
    }
}
