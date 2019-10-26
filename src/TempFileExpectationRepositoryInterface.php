<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Request\Request;
use mabrahao\MockServer\Response\Response;

class TempFileExpectationRepositoryInterface implements ExpectationRepositoryInterface
{
    /** @var string */
    private $tmpDir;
    /** @var string */
    private $tmpPath;

    /**
     * TmpFileExpectationRepository constructor.
     */
    public function __construct()
    {
        $tmpDir = sys_get_temp_dir() ?? '/tmp';
        $tmpPath = $tmpDir . DIRECTORY_SEPARATOR . 'mock-server';

        $this->tmpDir = $tmpDir;
        $this->tmpPath = $tmpPath;
    }


    /**
     * @param Expectation $expectation
     * @return bool
     */
    public function store(Expectation $expectation): bool
    {
        try {
            if (!is_dir($this->tmpPath)) {
                mkdir($this->tmpPath);
            }

            $uniqid = uniqid('request-');
            $filePath = $this->tmpPath . DIRECTORY_SEPARATOR . "{$uniqid}.config";

            $file = fopen($filePath, "w");
            fwrite($file, json_encode($expectation->toArray()));
            fclose($file);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return Expectation[]
     */
    public function fetchAll(): array
    {
        if(!is_dir($this->tmpPath)) {
            die('Path does not exist');
        }

        $files = array_filter(
            scandir($this->tmpPath, 1),
            function ($file) {
                if (preg_match('/^request-(.*)\.config/',$file)) {
                    return $file;
                }
            }
        );

        return array_map(
            function (string $filePath) {
                $config = json_decode(
                    file_get_contents(
                        $this->tmpPath . DIRECTORY_SEPARATOR . $filePath,
                        "r"
                    ),
                    true
                );

                $request = $config['request'];
                $times = $config['times'];
                $response = $config['response'];

                $expectation = new Expectation(
                    Request::fromArray($request),
                    Times::exactly(intval($times))
                );

                $expectation->setResponse(
                    Response::fromArray($response)
                );

                return $expectation;
            },
            $files
        );
    }

    /**
     * @return bool
     */
    public function nukeAllExpectations(): bool
    {
        try {
            $files = array_filter(
                scandir($this->tmpPath, 1),
                function ($file) {
                    if (preg_match('/^request-(.*)\.config/', $file)) {
                        return $file;
                    }
                }
            );

            foreach ($files as $file) {
                echo $this->tmpPath . DIRECTORY_SEPARATOR . $file;
                echo PHP_EOL;
                unlink($this->tmpPath . DIRECTORY_SEPARATOR . $file);
                echo "sucesso";
                echo PHP_EOL;

            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
