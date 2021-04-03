# Laravel Simple Order System

## Installation

1. Make sure Docker is installed on your environment (https://www.docker.com/products/docker-desktop)
2. git clone https://github.com/Kamax123/laravel-simple-order-system.git
3. cd laravel-simple-order-system
4. cp .env.example .env
5.   
   ``````
   docker run --rm \
   -v $(pwd):/opt \
   -w /opt \
   laravelsail/php74-composer:latest \
   composer install
6. ./vendor/bin/sail up
7. docker exec -it laravel-simple-order-system_laravel.test_1 php artisan key:generate
8. docker exec -it laravel-simple-order-system_laravel.test_1 php artisan migrate --seed

That's it! Now you should have the environment set up on your local. Go to 'localhost' in your
browser to use the app.

If you want to see e-mails go to 'http://localhost:8025/' in your browser. This will open the
Mailhog interface which will display all the sent e-mails from the app.

To stop the application, run './vendor/bin/sail down'

## Features

- Order system with automatic dummy data generator
- Ability to create an invoice in JSON or HTML format
- Sending an e-mail with the invoice to the specified e-mail address
