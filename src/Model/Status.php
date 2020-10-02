<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Model;

/**
 * Status
 */
class Status
{
    /**
     * Name of the array key for the pool field.
     * @var string
     */
    public const FIELD_POOL = 'pool';

    /**
     * Name of the array key for the process manager field.
     * @var string
     */
    public const FIELD_MANAGER = 'process manager';

    /**
     * Name of the array key for the start time field.
     * @var string
     */
    public const FIELD_START_TIME = 'start time';

    /**
     * Name of the array key for the start since field.
     * @var string
     */
    public const FIELD_START_SINCE = 'start since';

    /**
     * Name of the array key for the accepted connections field.
     * @var string
     */
    public const FIELD_ACCEPTED_CONN = 'accepted conn';

    /**
     * NAme of the array key for the listen queue field.
     * @var string
     */
    public const FIELD_LISTEN_QUEUE = 'listen queue';

    /**
     * Name of the array key for the maximum listen queue field.
     * @var string
     */
    public const FIELD_MAX_LISTEN_QUEUE = 'max listen queue';

    /**
     * Name of the array key for the listen queue length field.
     * @var string
     */
    public const FIELD_LISTEN_QUEUE_LEN = 'listen queue len';

    /**
     * Name of the array key for the idle processes field.
     * @var string
     */
    public const FIELD_IDLE_PROCESSES = 'idle processes';

    /**
     * Name of the array key for the active processes field.
     * @var string
     */
    public const FIELD_ACTIVE_PROCESSES = 'active processes';

    /**
     * Name of the array key for the total processes field.
     * @var string
     */
    public const FIELD_TOTAL_PROCESSES = 'total processes';

    /**
     * Name of the array key for the maximum active processes field.
     * @var string
     */
    public const FIELD_MAX_ACTIVE_PROCESSES = 'max active processes';

    /**
     * Name of the array key for the maximum children reached field.
     * @var string
     */
    public const FIELD_MAX_CHILDREN_REACHED = 'max children reached';

    /**
     * Name of the array key for the slow requests field.
     * @var string
     */
    public const FIELD_SLOW_REQUESTS = 'slow requests';

    /**
     * Name of the array key for the processes list field.
     * @var string
     */
    public const FIELD_PROCESSES = 'processes';

    /**
     * The total number of accepted connections by the pool.
     *
     * @var int
     */
    protected $acceptedConnections = 0;

    /**
     * The number of currently active processes.
     *
     * @var int
     */
    protected $activeProcesses = 0;

    /**
     * The number of currently idle processes.
     *
     * @var int
     */
    protected $idleProcesses = 0;

    /**
     * Type of the pools process manager.
     * Either static, dynamic or ondemand.
     *
     * @var string
     */
    protected $manager = '';

    /**
     * The maximum number of active processes since FPM was started.
     *
     * @var int
     */
    protected $maxActiveProcesses = 0;

    /**
     * Number of times the process limit has been reached when the
     * process manager tries to start more children.
     * Works only for pm 'dynamic' or 'ondemand'
     *
     * @var int
     */
    protected $maxChildrenReached = 0;

    /**
     * UNIX timestamp of the moment FPM was started.
     *
     * @var int
     */
    protected $startTime = 0;

    /**
     * Number of seconds since FPM was started.
     *
     * @var int
     */
    protected $startSince = 0;

    /**
     * The number of requests in the queue of pending connections.
     * If this number is non-zero, then you better increase number
     * of process FPM can spawn.
     *
     * @see backlog in listen(2)
     * @var int
     */
    protected $listenQueue = 0;

    /**
     * The maximum number of requests in the queue of pending connections
     * since FPM was started.
     *
     * @var int
     */
    protected $maxListenQueue = 0;

    /**
     * Name of the used FPM pool.
     *
     * @var string
     */
    protected $pool = '';

    /**
     * The sum of the active and idle processes.
     *
     * @var int
     */
    protected $totalProcesses = 0;

    /**
     * Number of slow PHP requests.
     *
     * @var int
     */
    protected $slowRequests = 0;

    /**
     * Array containing detailed process information for all currently active
     * processes. Only set if full status was requestd.
     *
     * @var array
     */
    protected $processes = [];

    /**
     * Create a new status from the given data.
     *
     * @param array $data The output from the fpm status page
     */
    public function __construct(array $data)
    {
        $this->update($data);
    }

    /**
     * Update the status information with the given data.
     *
     * @param array $data The output from the fpm status page
     * @return void
     */
    public function update(array $data): void
    {
        $this->acceptedConnections = $data[self::FIELD_ACCEPTED_CONN] ?? 0;
        $this->activeProcesses = $data[self::FIELD_ACTIVE_PROCESSES] ?? 0;
        $this->idleProcesses = $data[self::FIELD_IDLE_PROCESSES] ?? 0;
        $this->manager = $data[self::FIELD_MANAGER] ?? '';
        $this->maxActiveProcesses = $data[self::FIELD_MAX_ACTIVE_PROCESSES] ?? 0;
        $this->maxChildrenReached = $data[self::FIELD_MAX_CHILDREN_REACHED] ?? 0;
        $this->maxListenQueue = $data[self::FIELD_MAX_LISTEN_QUEUE] ?? 0;
        $this->pool = $data[self::FIELD_POOL] ?? '';
        $this->processes = [];
        $this->slowRequests = $data[self::FIELD_SLOW_REQUESTS] ?? 0;
        $this->startSince = $data[self::FIELD_START_SINCE] ?? 0;
        $this->startTime = $data[self::FIELD_START_TIME] ?? 0;
        $this->totalProcesses = $data[self::FIELD_TOTAL_PROCESSES] ?? 0;

        if (!empty($data[self::FIELD_PROCESSES]) && is_array($data[self::FIELD_PROCESSES])) {
            $this->readProcessData($data[self::FIELD_PROCESSES]);
        }
    }

    /**
     * Convert the process data into objects.
     *
     * @param array $data The process data
     * @return void
     */
    protected function readProcessData(array $data): void
    {
        /* Unset current processes */
        $this->processes =  [];

        for ($i = 0, $c = count($data); $i < $c; ++$i) {
            $this->processes[] = new Process($data[$i]);
        }
    }

    /**
     *
     * @return int
     */
    public function getAcceptedConnections(): int
    {
        return $this->acceptedConnections;
    }

    /**
     *
     * @return int
     */
    public function getActiveProcesses(): int
    {
        return $this->activeProcesses;
    }

    /**
     *
     * @return int
     */
    public function getIdleProcesses(): int
    {
        return $this->idleProcesses;
    }

    /**
     *
     * @return string
     */
    public function getManager(): string
    {
        return $this->manager;
    }

    /**
     *
     * @return int
     */
    public function getMaxActiveProcesses(): int
    {
        return $this->maxActiveProcesses;
    }

    /**
     *
     * @return int
     */
    public function getMaxChildrenReached(): int
    {
        return $this->maxChildrenReached;
    }

    /**
     *
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->startTime;
    }

    /**
     *
     * @return int
     */
    public function getStartSince(): int
    {
        return $this->startSince;
    }

    /**
     *
     * @return int
     */
    public function getListenQueue(): int
    {
        return $this->listenQueue;
    }

    /**
     *
     * @return int
     */
    public function getMaxListenQueue(): int
    {
        return $this->maxListenQueue;
    }

    /**
     *
     * @return string
     */
    public function getPool(): string
    {
        return $this->pool;
    }

    /**
     *
     * @return int
     */
    public function getTotalProcesses(): int
    {
        return $this->totalProcesses;
    }

    /**
     *
     * @return int
     */
    public function getSlowRequests(): int
    {
        return $this->slowRequests;
    }

    /**
     *
     * @return array
     */
    public function getProcesses(): array
    {
        return $this->processes;
    }
}
