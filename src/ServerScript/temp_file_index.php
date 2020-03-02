<?php

require __DIR__ . '/../../vendor/autoload.php';

use mabrahao\MockServer\RequestHandlerBuilder;
use mabrahao\MockServer\Enum\Storage;

$PHP_INPUT = file_get_contents("php://input");

$requestHandler = RequestHandlerBuilder::build(Storage::TEMP_FILE, $_SERVER, $_POST, $PHP_INPUT);
$requestHandler->dispatch();