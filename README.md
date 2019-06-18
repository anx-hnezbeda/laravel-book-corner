# Start project

```
mkdir app
```

```
docker-compose run --rm app "composer create-project --prefer-dist laravel/laravel ."
```

```
chmod -R 777 app/storage
```

##Loading Demo Data
This application provides an Artisan-based command, which makes it possible to quickly and easily populate the database with demo data.

With the optional Argument ``--refresh`` the database will be also refreshed.

```
docker-compose run --rm app php artisan lbc:load-demo-data --refresh
```
