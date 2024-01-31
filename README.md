## Requirements
- PHP 8.2
- composer

## Installation
```
composer install
cp .env.example .env
php artisan key:generate
``

Update the database settings in `.env`:
```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Run the migrations:
```
php artisan migrate
```
