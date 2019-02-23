<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Domain\Request;
use mabrahao\MockServer\Domain\RequestHandler;
use mabrahao\MockServer\Exceptions\RuntimeException;
use mabrahao\MockServer\Infrastructure\DefaultRequestHandler;

class MockServer
{
    /** @var string */
    private $host;
    /** @var int */
    private $port;
    private $pid;

    /**
     * MockServer constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host = '127.0.0.1', int $port = 0)
    {
        $this->host = $host;
        $this->port = $port;

        if ($port === 0) {
            $this->port = $this->findAvailablePort();
        }

    }

    private function findAvailablePort(): int
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if(!socket_bind($socket, $this->host, 0)) {
            throw new RuntimeException('Unable to bind address');
        }

        socket_getsockname($socket, $addr, $port);
        socket_close($socket);

        if($port > 0) {
            return $port;
        }

        throw new RuntimeException('No available for found');
    }

    public function run()
    {
        $script = __DIR__ . DIRECTORY_SEPARATOR . 'server.php';

        $stdout = tempnam(sys_get_temp_dir(), 'mabrahao-ms-');
        $phpCmd    = "php -S {$this->host}:{$this->port} " . escapeshellarg($script);

        $cmd = sprintf('%s > %s 2>&1 & echo $!',
            escapeshellcmd($phpCmd),
            escapeshellarg($stdout)
        );

        $this->pid = exec($cmd,$output, $return);
    }

    public function when(Request $request): RequestHandler
    {
        return new DefaultRequestHandler($request);
    }

    public function stop()
    {
        exec(sprintf('kill %d', $this->pid));
    }

    public function getServerUrl(): string
    {
        return "http://{$this->host}:{$this->port}";
    }

    public function __destruct()
    {
        $this->stop();
    }
}
