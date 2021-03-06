<?php

namespace Mabrahao\MockServer\ExpectationRepository;

use Mabrahao\MockServer\Model\Expectation;
use Mabrahao\MockServer\Model\Request;
use Mabrahao\MockServer\Model\Response;
use Mabrahao\MockServer\Model\Times;

class TempFileExpectationRepository implements ExpectationRepositoryInterface
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

            $uniqId = $expectation->getId();

            if (!$uniqId) {
                $uniqId = uniqid('request-');
                $expectation->setId($uniqId);
            }

            $filePath = $this->tmpPath . DIRECTORY_SEPARATOR . "{$uniqId}.config";

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

                return new Expectation(
                    $config['id'],
                    Request::fromArray($config['request']),
                    Times::fromArray($config['times']),
                    Response::fromArray($config['response'])
                );
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
            $files = scandir($this->tmpPath, 1);
            array_walk(
                $files,
                function ($file) {
                    if (preg_match('/^request-(.*)\.config/', $file)) {
                        unlink($this->tmpPath . DIRECTORY_SEPARATOR . $file);
                    }
                }
            );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
