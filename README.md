# CRUD-perqara

## How to run 

run code below

```bash
composer install
run php artisan clear
php artisan cache:clear
php artisan serve
```

## Code linting

run code below

```bash
pint --preset psr12
```

## Start open API server
first install swagger-php and l5-swagger
```bash
composer require zircote/swagger-php
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

generate swagger file using
```bash
php artisan l5-swagger:generate
```
open documentation by opening `localhost:8000/api/documentation`

## Unit test
run 
```bash
php artisan test
```
