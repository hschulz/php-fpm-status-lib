<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Model;

/**
 * Description of Entry
 */
class Entry
{
    /**
     * @var int
     */
    public const PRIORITY_LOWEST = 0;

    /**
     * @var int
     */
    public const PRIORITY_LOW = 25;

    /**
     * @var int
     */
    public const PRIORITY_MEDIUM = 50;

    /**
     * @var int
     */
    public const PRIORITY_HIGH = 75;

    /**
     * @var int
     */
    public const PRIORITY_HIGHEST = 100;

    /**
     * @var int
     */
    public const STATUS_OK = 0;

    /**
     * @var int
     */
    public const STATUS_ERROR = 1;

    /**
     *
     * @var string
     */
    protected $message = '';

    /**
     *
     * @var int
     */
    protected $status = 0;

    /**
     *
     * @var int
     */
    protected $priority = self::PRIORITY_LOWEST;

    /**
     *
     * @param string $message
     * @param int $status
     * @param int $priority
     */
    public function __construct(
        string $message,
        int $status = self::STATUS_OK,
        int $priority = self::PRIORITY_LOWEST
    ) {
        $this->message = $message;
        $this->status = $status;
        $this->priority = $priority;
    }

    /**
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     *
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     *
     * @param int $priority
     * @return void
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
