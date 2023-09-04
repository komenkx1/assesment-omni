 
 
 ## Installation 
 
  
 - Clone this repository 
 - Composer install 
 - Copy .env.example to .env 
 - php artisan key:generate 
 - php artisan migrate 
 - npm install 
 - npm run dev 
 - php artisan serve 
 - run unittest 
 
  
 > Note:
 - set QUEUE_CONNECTION=database untuk menggunakan queue
 - to run the queue, run the command ` php artisan queue:work ` in the terminal 
 - api for mass insert user ` api/user/batch-insert ` 
 - to run email send, set SMTP in .env and run command ` php artisan queue:work ` in terminal 
 - the user insert API batch array form is as follows: 
 ``` php 
 { 
 "data": [ 
 { 
 "name": "Buckner Mckenzie", 
 "email": "bucknermckenzie@isologia.com", 
 "phone": "(953) 548-3708", 
 "password": "password" 
 }, 
 { 
 "name": "Little Pickett", 
 "email": "littlepickett@isologia.com", 
 "phone": "(801) 511-3165", 
 "passwords": "passwords" 
 }, 
 { 
 "name": "Rose Shannon", 
 "email": "roseshannon@isologia.com", 
 "phone": "(953) 539-3399", 
 "passwords": "passwords" 
 } 
 ] 
 } 
 ``` 
 
