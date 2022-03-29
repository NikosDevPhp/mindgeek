<?php

namespace App\Console\Commands;

use App\Services\MovieProviderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncMoviesCommand extends Command
{

    private const MOVIE_FEED_URL='https://mgtechtest.blob.core.windows.net/files/showcase.json';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get(self::MOVIE_FEED_URL);

        $movieProviderService = app()->make(MovieProviderService::class);
        $result = $movieProviderService->getMovies($response->body());
        if ($result) {
            $this->info('Process completed successfully');
        } else {
            $this->info('Some things went wrong during syncing, check error logs');
        }
        return 0;
    }
}
