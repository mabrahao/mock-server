<?php

require __DIR__ . '/Domain/RequestMatcher.php';

use mabrahao\MockServer\Domain\RequestMatcher;

$tmpDir = sys_get_temp_dir() ?: '/tmp';

$tmpPath = $tmpDir . DIRECTORY_SEPARATOR . 'mock-server';

if(!is_dir($tmpPath)) {
    die('Path does not exist');
}

$files = array_filter(
    scandir($tmpPath, 1),
    function ($file) {
        if (preg_match('/^request-(.*)\.config/',$file)) {
            return $file;
        }
    }
);

$PHP_INPUT = file_get_contents("php://input");

foreach ($files as $file) {
    $config = json_decode(
        file_get_contents(
            $tmpPath . DIRECTORY_SEPARATOR . $file,
            "r"
        ),
        true
    );

    (new RequestMatcher($config, $_SERVER, $PHP_INPUT, $_POST))->match();
}
