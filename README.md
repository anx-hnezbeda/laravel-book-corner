## Start project

You can run the Book Corner API using the provided Docker setup for development:

```
docker-compose run --rm app "composer install"
chmod -R 777 app/storage
docker-compose up
```

In a paralel console you can run the migrations:

```
docker-compose run --rm app php artisan migrate
```

The following API endpoints are available:

* [/api/v1/authors](http://localhost/api/v1/authors)
* [/api/v1/books](http://localhost/api/v1/books)
* [/api/v1/bookuser](http://localhost/api/v1/bookuser)
* [/api/v1/categories](http://localhost/api/v1/categories)
* [/api/v1/publishers](http://localhost/api/v1/publishers)
* [/api/v1/tags](http://localhost/api/v1/tags)
* [/api/v1/users](http://localhost/api/v1/users)

## Loading Demo Data
This application provides an Artisan-based command, which makes it possible to quickly and easily populate the database with demo data.

With the optional Argument ``--refresh`` the database will be also refreshed.

```
docker-compose run --rm app php artisan lbc:load-demo-data --refresh
```
