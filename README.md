# Installation

cd into the project dir and run
```bash
./vendor/bin/sail up -d
```

If you use sail default configuration should be:
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mindgeek
DB_USERNAME=sail
DB_PASSWORD=password
```


Run the migrations
```bash
./vendor/bin/sail artisan migrate
```

Set your APP_URL and add it to your hosts file

Run the feed sync command
```bash
./vendor/bin/sail artisan sync:movies
```

Images are saved in storage/app/public, we need to link them to public directory
```bash
./vendor/bin/sail artisan storage:link
```


If you do not use sail but have docker enabled on your machine you can use following commands from inside the root directory:
```bash
docker-compose up -d
```

and
```bash
docker-compose exec --u sail laravel.test bash
```
to have a shell inside the container and run artisan commands normally from there


