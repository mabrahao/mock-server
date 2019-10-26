<?php

require __DIR__ . '/../../vendor/autoload.php';

use mabrahao\MockServer\Matchers\RequestMatcher;
use mabrahao\MockServer\Storage;

$PHP_INPUT = file_get_contents("php://input");

$matcher = new RequestMatcher(Storage::TEMP_FILE, $_SERVER, $_POST, $PHP_INPUT);
$matcher->dispatch();