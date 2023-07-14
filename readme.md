# Suryadaya Website
## Requirements
    $ php 7.0 +
    $ node.js

## Setting up development environment

    // Clone the project.
    
    $ cp .env.example .env
    $ composer install
    $ php artisan storage:link
    $ npm install
    $ npm run dev
    $ php artisan migrate:fresh --seed

## Running artisan and node command
    $ php artisan serve
    $ npm run watch
