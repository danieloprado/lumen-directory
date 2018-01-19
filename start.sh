if [ "$1" = "--help" ] || [ "$1" = "-h" ]; then
  echo "Options:
  --help  -h    Show options
  --dev   -d    Start the development server
  --test  -t    Start the tests
";
  exit 0;
fi

if [ "$1" = '--dev' ] || [ "$1" = '-d' ]; then
  docker-compose up $2
  exit 0;
fi

if [ "$1" = '--t' ] || [ "$1" = '-t' ]; then
  docker-compose -f docker-compose-test.yml up $2
  exit 0;
fi

echo "Invalid options, type --help to see more options..."