<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Model;

/**
 * Description of PoolConfig
 */
class PoolConfig
{
    /**
     * The number of child processes to be created when pm is set to static
     * and the maximum number of child processes to be created
     * when pm is set to dynamic. This option is mandatory.
     *
     * This option sets the limit on the number of simultaneous requests
     * that will be served. Equivalent to the ApacheMaxClients directive
     * with mpm_prefork and to the PHP_FCGI_CHILDREN environment variable
     * in the original PHP FastCGI.
     *
     * @var int
     */
    protected $maxChildren = 0;

    /**
     * The desired minimum number of idle server processes.
     * Used only when pm is set to dynamic. Also mandatory in this case.
     *
     * @var int
     */
    protected $minSpareServer = 0;

    /**
     * The desired maximum number of idle server processes.
     * Used only when pm is set to dynamic. Also mandatory in this case.
     *
     * @var int
     */
    protected $maxSpareServers = 0;

    /**
     * The number of seconds after which an idle process will be killed.
     * Used only when pm is set to ondemand.
     * Available units: s(econds)(default), m(inutes), h(ours), or d(ays).
     * Default value: 10s.
     *
     * @var string
     */
    protected $idleTimeout = '';

    /**
     * The number of requests each child process should execute before respawning.
     * This can be useful to work around memory leaks in 3rd party libraries.
     * For endless request processing specify '0'.
     * Equivalent to PHP_FCGI_MAX_REQUESTS. Default value: 0.
     *
     * @var int
     */
    protected $maxRequests = 0;

    /**
     *
     */
    public function __construct()
    {
        $this->idleTimeout = '';
        $this->maxChildren = 0;
        $this->maxRequests = 0;
        $this->maxSpareServers = 0;
        $this->minSpareServer = 0;
    }

    /**
     *
     * @return int
     */
    public function getMaxChildren(): int
    {
        return $this->maxChildren;
    }

    /**
     *
     * @param int $maxChildren
     * @return void
     */
    public function setMaxChildren(int $maxChildren): void
    {
        $this->maxChildren = $maxChildren;
    }

    /**
     *
     * @return int
     */
    public function getMinSpareServer(): int
    {
        return $this->minSpareServer;
    }

    /**
     *
     * @param int $minSpareServer
     * @return void
     */
    public function setMinSpareServer(int $minSpareServer): void
    {
        $this->minSpareServer = $minSpareServer;
    }

    /**
     *
     * @return int
     */
    public function getMaxSpareServers(): int
    {
        return $this->maxSpareServers;
    }

    /**
     *
     * @param int $maxSpareServers
     * @return void
     */
    public function setMaxSpareServers(int $maxSpareServers): void
    {
        $this->maxSpareServers = $maxSpareServers;
    }

    /**
     *
     * @return int
     */
    public function getIdleTimeout(): int
    {
        return $this->idleTimeout;
    }

    /**
     *
     * @param string $idleTimeout
     * @return void
     */
    public function setIdleTimeout(string $idleTimeout): void
    {
        $unit = $idleTimeout[mb_strlen($idleTimeout) - 1];

        $this->idleTimeout = (int) $idleTimeout;

        switch ($unit) {
            case 'm':
                $this->idleTimeout *= 60;
                break;
            case 'h':
                $this->idleTimeout *= 3600;
                break;
            case 'd':
                $this->idleTimeout *= 86400;
        }
    }

    /**
     *
     * @return int
     */
    public function getMaxRequests(): int
    {
        return $this->maxRequests;
    }

    /**
     *
     * @param int $maxRequests
     * @return void
     */
    public function setMaxRequests(int $maxRequests): void
    {
        $this->maxRequests = $maxRequests;
    }
}
