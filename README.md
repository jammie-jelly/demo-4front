#### Demo for money tracker

##### Requirements:
- PHP 8.4
- Composer
- NPM

##### Setup: (in order)
Install dependencies
- `composer install`
- `npm install --omit=dev`

Copy swagger-ui assets
- `mkdir -p public/vendor/swagger-ui-dist`
- `cp -r node_modules/swagger-ui-dist/ public/vendor`

Setup Database
- `touch "$(pwd)/test"`
- `export DB_DATABASE="$(pwd)/test"`
- `php artisan migrate`
- `php artisan key:generate`

Start application
- `php artisan serve`

##### Usage:

http://localhost:8000 serves the frontend application

http://localhost:8000/api/documentation serves the swagger UI API documentation
