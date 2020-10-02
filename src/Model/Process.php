<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Model;

/**
 * Process
 */
class Process
{
    /**
     * @var string
     */
    public const FIELD_PID = 'pid';

    /**
     * @var string
     */
    public const FIELD_STATE = 'state';

    /**
     * @var string
     */
    public const FIELD_START_TIME = 'start time';

    /**
     * @var string
     */
    public const FIELD_START_SINCE = 'start since';

    /**
     * @var string
     */
    public const FIELD_REQUESTS = 'requests';

    /**
     * @var string
     */
    public const FIELD_REQUEST_DURATION = 'request duration';

    /**
     * @var string
     */
    public const FIELD_REQUEST_METHOD = 'request method';

    /**
     * @var string
     */
    public const FIELD_REQUEST_URI = 'request uri';

    /**
     * @var string
     */
    public const FIELD_CONTENT_LENGTH = 'content length';

    /**
     * @var string
     */
    public const FIELD_USER = 'user';

    /**
     * @var string
     */
    public const FIELD_SCRIPT = 'script';

    /**
     * @var string
     */
    public const FIELD_LAST_REQUEST_CPU = 'last request cpu';

    /**
     * @var string
     */
    public const FIELD_LAST_REQUEST_MEMORY = 'last request memory';

    /**
     * The pid of the process.
     *
     * @var int
     */
    protected $pid = 0;

    /**
     * Current state of the process.
     *
     * @var string
     */
    protected $state = '';

    /**
     * Number of seconds since the service was started.
     *
     * @var int
     */
    protected $startSince = 0;

    /**
     * UNIX timestamp from the moment the process was started.
     *
     * @var int
     */
    protected $startTime = 0;

    /**
     * The number of requests this process has served.
     *
     * @var int
     */
    protected $requests = 0;

    /**
     * Time in microseconds it took to handle the last request.
     *
     * @var int
     */
    protected $requestDuration = 0;

    /**
     * The http request method used for the last request.
     *
     * @var string
     */
    protected $requestMethod = '';

    /**
     * The uri of the last request.
     *
     * @var string
     */
    protected $requestUri = '';

    /**
     * Size of the POST payload.
     *
     * @var int
     */
    protected $contentLength = 0;

    /**
     * Value of PHP_AUTH_USER or '-' if unset.
     *
     * @var string
     */
    protected $user = '';

    /**
     * The PHP script that was called or '-' if unset.
     *
     * @var string
     */
    protected $script = '';

    /**
     * The percentage of CPU usage it took to handle the last request.
     * This is always 0 for active processes because the calculation takes
     * place after the request is finished.
     *
     * @var float
     */
    protected $lastRequestCpu = 0.0;

    /**
     * @var int
     */
    protected $lastRequestMemory = 0;

    /**
     * Creates a new process status from the given data.
     *
     * @param array $data Collected php-fpm process data
     */
    public function __construct(array $data)
    {
        $this->parse($data);
    }

    /**
     * Parses the given php-fpm process data into this objects members.
     *
     * @param array $data Collected php-fpm process data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->contentLength = $data[self::FIELD_CONTENT_LENGTH] ?? 0;
        $this->lastRequestCpu = $data[self::FIELD_LAST_REQUEST_CPU] ?? 0.0;
        $this->lastRequestMemory = $data[self::FIELD_LAST_REQUEST_MEMORY] ?? 0;
        $this->pid = $data[self::FIELD_PID] ?? 0;
        $this->requests = $data[self::FIELD_REQUESTS] ?? 0;
        $this->requestDuration = $data[self::FIELD_REQUEST_DURATION] ?? 0;
        $this->requestMethod = $data[self::FIELD_REQUEST_METHOD] ?? '';
        $this->requestUri = $data[self::FIELD_REQUEST_URI] ?? '';
        $this->script = $data[self::FIELD_SCRIPT] ?? '';
        $this->startSince = $data[self::FIELD_START_SINCE] ?? 0;
        $this->startTime = $data[self::FIELD_START_TIME] ?? 0;
        $this->state = $data[self::FIELD_STATE] ?? '';
        $this->user = $data[self::FIELD_USER] ?? '';
    }

    /**
     * Returns the process id.
     *
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * Returns the process state.
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
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
     * Returns the process start timestamp.
     *
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->startTime;
    }

    /**
     * Returns the number of requests served by this process.
     *
     * @return int
     */
    public function getRequests(): int
    {
        return $this->requests;
    }

    /**
     *
     * @return int
     */
    public function getRequestDuration(): int
    {
        return $this->requestDuration;
    }

    /**
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     *
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     *
     * @return int
     */
    public function getContentLength(): int
    {
        return $this->contentLength;
    }

    /**
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     *
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     *
     * @return float
     */
    public function getLastRequestCpu(): float
    {
        return $this->lastRequestCpu;
    }

    /**
     *
     * @return int
     */
    public function getLastRequestMemory(): int
    {
        return $this->lastRequestMemory;
    }

    /**
     *
     * @param int $pid
     * @return void
     */
    public function setPid(int $pid): void
    {
        $this->pid = $pid;
    }

    /**
     *
     * @param string $state
     * @return void
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     *
     * @param int $startTime
     * @return void
     */
    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     *
     * @param int $startSince
     * @return void
     */
    public function setStartSince(int $startSince): void
    {
        $this->startSince = $startSince;
    }

    /**
     *
     * @param int $requests
     * @return void
     */
    public function setRequests(int $requests): void
    {
        $this->requests = $requests;
    }

    /**
     *
     * @param int $requestDuration
     * @return void
     */
    public function setRequestDuration(int $requestDuration): void
    {
        $this->requestDuration = $requestDuration;
    }

    /**
     *
     * @param string $requestMethod
     * @return void
     */
    public function setRequestMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     *
     * @param string $requestUri
     * @return void
     */
    public function setRequestUri(string $requestUri): void
    {
        $this->requestUri = $requestUri;
    }

    /**
     *
     * @param int $contentLength
     * @return void
     */
    public function setContentLength(int $contentLength): void
    {
        $this->contentLength = $contentLength;
    }

    /**
     *
     * @param string $user
     * @return void
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     *
     * @param string $script
     * @return void
     */
    public function setScript(string $script): void
    {
        $this->script = $script;
    }

    /**
     *
     * @param float $lastRequestCpu
     * @return void
     */
    public function setLastRequestCpu(float $lastRequestCpu): void
    {
        $this->lastRequestCpu = $lastRequestCpu;
    }

    /**
     *
     * @param int $lastRequestMemory
     * @return void
     */
    public function setLastRequestMemory(int $lastRequestMemory): void
    {
        $this->lastRequestMemory = $lastRequestMemory;
    }
}
