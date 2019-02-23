<?php
use mabrahao\MockServer\Domain\RequestMatcher;

require __DIR__ . '/../vendor/autoload.php';

$tmpDir = sys_get_temp_dir() ?: '/tmp';
$config = json_decode(
    file_get_contents(
        $tmpDir . DIRECTORY_SEPARATOR . "request.config",
        "r"
    ),
    true
);

$PHP_INPUT = file_get_contents("php://input");

(new RequestMatcher($config, $_SERVER, $PHP_INPUT, $_POST))->match();
