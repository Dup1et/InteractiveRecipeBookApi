# Installation

Install dependencies via composer
```bash
composer install
```

Run devserver
```bash
docker-compose up --build
```

Run migrations with seeds
```bash
docker-compose exec php-fpm php artisan migrate --seed
```
