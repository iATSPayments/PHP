<?php

// Set the default timezone for our tests to strtotime() doesn't fail.
date_default_timezone_set('UTC');

// Warn and exit if autoloader fails.
if (!$loader = @include __DIR__.'/../vendor/autoload.php') {
  echo <<<EOM
You must set up the project dependencies by running the following commands:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

EOM;
  exit(1);
}
