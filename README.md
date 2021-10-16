

## Postman
```text
 Postman json data file example in folder public
```

## Installation

```shell
 git clone https://github.com/dima-php/zp-task.git zp-task
```

```shell
 cd task && composer install
```

```shell
 cp .env.example .env
```

```shell
nano .env
```

```dotenv
DB_HOST=db
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_passwor
```

```shell
php artisan key:generate
```
```shell
php artisan migrate:fresh --seed
```

## Run the application

```shell
php artisan migrate:fresh --seed && php artisan serve
```

or

```shell
php artisan sail:install && ./vendor/bin/sail up -d
```
```shell
./vendor/bin/sail artisan migrate:fresh --seed
```
