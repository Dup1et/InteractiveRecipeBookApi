# Installation

Install dependencies via composer
```bash
composer install
```
Copy ```.env.example``` to ```.env```
>Don't forget configure it!

# Devserver
Change DB_HOST to "irb.mysql"

Run devserver
```bash
docker-compose up --build
```
>If you use devserver prepend your commands with ```docker-compose exec php-fpm```

Generate app key
```bash
php artisan key:generate
```

Run migrations with seeds
```bash
php artisan migrate --seed
```
