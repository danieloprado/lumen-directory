/bin/sh -c "
  while ! nc -z $DB_HOST $DB_PORT;
  do
    echo 'Waiting database';
    sleep 1;
  done;
  echo 'Database ready!'!;
"

php artisan migrate
php -S 0.0.0.0:8080 -t ./public