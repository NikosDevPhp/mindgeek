# Installation

Ensure you have docker installed on your machine. If on Linux docker will work natively, if no Windows install Docker Desktop through WSL2.

cd into the project dir and run

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
This will install sail, composer dependencies through a mini container.

Then run the following command to create the network and containers
```bash
./vendor/bin/sail up -d
```
If for some reason in windows machine this does not work immediately restart your shell.

Create an .env file from the .env.example. 
If you use sail default configuration should be:
```bash
APP_URL=http://mindgeek.test

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mindgeek
DB_USERNAME=sail
DB_PASSWORD=password

// if you use debugger
SAIL_XDEBUG_MODE=develop,debug 
```

Generate app key
```bash
./vendor/bin/sail artisan key:generate
```

With your sql editor of choice (or though command line) create a schema named `mindgeek` and
run the migrations
```bash
./vendor/bin/sail artisan migrate
```

Set your APP_URL and add it to your hosts file

Run the feed sync command
```bash
./vendor/bin/sail artisan sync:movies
```

Images are saved in storage/app/public, to link them to public directory run
```bash
./vendor/bin/sail artisan storage:link
```


If you do not use sail but have docker enabled on your machine you can use following commands from inside the root directory:
```bash
docker-compose up -d
```
to bring up the servives

and
```bash
docker-compose exec --u sail laravel.test bash
```
to have a shell inside the container and run artisan commands normally from there


