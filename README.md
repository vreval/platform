# Vreval Platform

The VREVAL Platform is a web application to create and manage research projects that deal with user centered evaluations of virtual environments.

[Visit the preview](http://207.154.211.120/)

[Documentation](#) // TODO

## Installation

First, clone this repository.

`git clone https://github.com/vreval/platform.git vreval-platform`

### Run directly from disk

This project is built with the Laravel framework. To run in locally you need to have a development environment with PHP and MySql set up.

1. Create an `.env`-file: `cp .env.example .env`
2. Install the dependencies: `composer install`
3. Generate an application key: `php artisan key:generate`
4. Migrate the database: `php artisan migrate`

### Using Docker

If you are familiar with Docker, just run

`cd vreval-platform/docker && docker-compose up -d`

Setup the projet using the 4 steps above. Thats it.

