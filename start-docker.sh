echo "APP_ENV: $APP_ENV"

composer install --prefer-dist --no-progress --optimize-autoloader --no-interaction

if [ "$APP_ENV" == "testing" ]; then
  ./vendor/bin/phpunit
  exit 0
fi

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