<?php


declare(strict_types=1);

use Slim\App;
use \DI\Container;

/** @var Container $cnt */
$cnt = require_once __DIR__ . '/../bootstrap.php';

$app->run();