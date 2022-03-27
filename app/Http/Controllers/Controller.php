<?php

namespace App\Http\Controllers;

use App\Services\MovieProviderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(MovieProviderService $movieProviderService)
    {
        $x = $this->movieProviderService->getMovies();
    }
}
