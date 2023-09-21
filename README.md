### Prereqesite

1. php 8.2
1. postgresql
1. tailwindcss

### Setup

1. clone https://github.com/filjoseph1989/simple-laravel-10-crud to your local setup
1. run `composer install`
1. run `npm install`
1. update your `.env` file
1. run `php artisan migrate`
1. run `npm run build or dev`

### .env

Example of .env

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5433
    DB_DATABASE=simple_laravel_app
    DB_USERNAME=username
    DB_PASSWORD=password

If you want to test or run it in local, run the npm command, to show simple yet nice and front end layout.

    npm run build

If you you are on Linux kernel like Ubuntu you might want to setup local domain in hosts file.

Example:

    <VirtualHost *:8081>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        ServerName simple-laravel-app.test

        ServerAdmin admin@simple-laravel-app.test
        DocumentRoot /var/www/simple-laravel-app/public

        <Directory /var/www/simple-laravel-app/public/>
            Options Indexes FollowSymLinks
                AllowOverride All
            Require all granted
        </Directory>

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog /var/www/simple-laravel-app/error.log
        CustomLog /var/www/simple-laravel-app/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
    </VirtualHost>

With this, you can now visit on

    simple-laravel-app.test:8081

port 8081

### Test Data

There are two seeders included as well, you can run them individually

    php artisan db:seed --class=StoreSeeder
    php artisan db:seed --class=UserSeeder

### Feature test

This task was bundled with a feature test to ensure that all existing functionality remains intact when new code is added.

    php artisan test

You can inspect them at

    tests/Feature

There are so much to do, but I am ran out of time. I will continue later.

Thank you

---------------------------------------------

Fil Joseph Elman<br>
Web Ninja<br>
filjoseph22@gmail.com<br>
https://filjoseph1989.github.io<br>

