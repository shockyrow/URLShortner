# URLShortner
A service that allows shortening long URL's.

## Installation

0. Make sure you have composer, php, mysql installed on your system.
1. Copy ".env" to ".env.local".
2. Update `DATABASE_URL` in ".env.local" according to your system.
3. Run `composer install`.
4. Run `php bin/console doctrine:database:create` to create database.
5. Run `php bin/console doctrine:migrations:migrate` to migrate your database.
6. If you have symfony installed on your system, run `symfony server:start` to start the application.
7. If you don't have symfony, run `composer require --dev symfony/web-server-bundle` to install the web server bundle, then run `php bin/console server:start` to start the application.
8. That's it! Enjoy! :smile:

## How to use

### Via Curl

- To create a short url run `curl http://localhost:8000/url/create -d "url=http://example.com"`.
- To see all urls run `curl http://localhost:8000/url/all`.
- To see all urls for current session `curl http://localhost:8000/url/current`.
- All short urls will be in "http://localhost:8000/url/view/{id}" format.
