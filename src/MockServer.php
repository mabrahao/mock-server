<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Domain\RequestInterface;
use mabrahao\MockServer\Domain\RequestHandlerInterface;
use mabrahao\MockServer\Exceptions\BindAddressException;
use mabrahao\MockServer\Exceptions\NoAvailablePortException;
use mabrahao\MockServer\Infrastructure\TmpFileRequestHandler;

class MockServer
{
    /** @var string */
    private $host;
    /** @var int */
    private $port;
    /** @var int */
    private $pid;
    /** @var int */
    private $sleepTime;

    /**
     * MockServer constructor.
     * @param string $host
     * @param int $port
     * @param $sleepTime
     */
    public function __construct(string $host = '127.0.0.1', int $port = 0, $sleepTime = 200000)
    {
        $this->host = $host;
        $this->port = $port;

        if ($port === 0) {
            $this->port = $this->findAvailablePort();
        }

        $this->sleepTime = $sleepTime;
    }

    private function findAvailablePort(): int
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if(!socket_bind($socket, $this->host, 0)) {
            throw new BindAddressException('Unable to bind address');
        }

        socket_getsockname($socket, $addr, $port);
        socket_close($socket);

        if($port > 0) {
            return $port;
        }

        throw new NoAvailablePortException('No available for found');
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

        usleep($this->sleepTime);
    }

    public function when(RequestInterface $request): RequestHandlerInterface
    {
        return new TmpFileRequestHandler($request);
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
