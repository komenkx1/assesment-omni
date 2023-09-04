

## Instalation

<!-- buat bullet -->
- Clone this repository
- Composer install
- Copy .env.example to .env
- php artisan key:generate
- php artisan migrate
- npm install
- npm run dev
- php artisan serve
- run unitest

<!-- buat notes -->
> Note: 
- untuk menjalankan queue, jalankan perintah `php artisan queue:work` di terminal
- api untuk mass insert user `api/user/batch-insert`
- untuk menjalankan email send, setting SMTP di .env dan jalankan perintah `php artisan queue:work` di terminal
- bentuk array batch user insert API adalah sebagai berikut:
```php
{
    "data": [
        {
            "name": "Buckner Mckenzie",
            "email": "bucknermckenzie@isologia.com",
            "telepon": "(953) 548-3708",
            "password": "password"
        },
        {
            "name": "Little Pickett",
            "email": "littlepickett@isologia.com",
            "telepon": "(801) 511-3165",
            "password": "password"
        },
        {
            "name": "Rose Shannon",
            "email": "roseshannon@isologia.com",
            "telepon": "(953) 539-3399",
            "password": "password"
        }
    ]
}
```

