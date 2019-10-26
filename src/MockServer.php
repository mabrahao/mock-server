<?php

namespace mabrahao\MockServer;

use mabrahao\MockServer\Exceptions\NoAvailablePortException;
use mabrahao\MockServer\Exceptions\UnableToBindAddressException;

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
    /** @var boolean */
    private $running = false;
    /** @var string */
    private $storageType;

    /**
     * MockServer constructor.
     * @param string $host
     * @param int $port
     * @param int $sleepTime
     * @param string $storageType
     */
    public function __construct(string $host, int $port, int $sleepTime, string $storageType)
    {
        $this->host = $host;
        $this->port = $port;

        if ($port === 0) {
            $this->port = $this->findAvailablePort();
        }

        $this->sleepTime = $sleepTime;
        $this->storageType = $storageType;
    }

    private function findAvailablePort(): int
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if(!socket_bind($socket, $this->host, 0)) {
            throw new UnableToBindAddressException('Unable to bind address');
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
        $scriptName = $this->getScriptName();

        $script = __DIR__ . DIRECTORY_SEPARATOR . 'ServerScript' . DIRECTORY_SEPARATOR . $scriptName;

        $stdout = tempnam(sys_get_temp_dir(), 'logs-ms-');
        $phpCmd    = "php -S {$this->host}:{$this->port} " . escapeshellarg($script);

        $cmd = sprintf('%s > %s 2>&1 & echo $!',
            escapeshellcmd($phpCmd),
            escapeshellarg($stdout)
        );

        $this->pid = exec($cmd,$output, $return);

        usleep($this->sleepTime);

        $this->running = true;
    }

    public function stop()
    {
        exec(sprintf('kill %d', $this->pid));
        usleep($this->sleepTime);
        $this->running = false;
    }

    public function isRunning(): bool
    {
        return $this->running;
    }

    public function getUrl()
    {
        return "http://{$this->host}:{$this->port}";
    }

    private function getScriptName(): string
    {
        switch ($this->storageType) {
            case Storage::TEMP_FILE:
            default:
                return 'temp_file_index.php';
        }
    }
}
