composer install --prefer-dist --no-progress --optimize-autoloader --no-interaction
composer dump-autoload -o 

/bin/sh -c "
  while ! nc -z $DB_HOST $DB_PORT;
  do
    echo 'Waiting database';
    sleep 1;
  done;
  echo 'Database ready!'!;
"

php artisan migrate
php artisan db:seed

php -S 0.0.0.0:8080 -t ./public