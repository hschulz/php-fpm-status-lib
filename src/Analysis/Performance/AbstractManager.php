<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Analysis\Performance;

use Hschulz\FpmStatus\Model\PoolConfig;
use Hschulz\FpmStatus\Model\Status;
use function round;

/**
 * Description of AbstractManager
 */
abstract class AbstractManager implements ManagerInterface
{
    /**
     *
     * @var Status
     */
    protected $status = null;

    /**
     *
     * @var PoolConfig
     */
    protected $config = null;

    /**
     *
     */
    public function __construct()
    {
        $this->status = null;
        $this->config = null;
    }

    public function getPerformanceData(Status $status, ?PoolConfig $config = null): array
    {
        $this->status = $status;
        $this->config = $config;

        return [
            'accepted_connections' => $this->status->getAcceptedConnections(),
            'active_processes' => $this->status->getActiveProcesses(),
            'idle_processes' => $this->status->getIdleProcesses(),
            'listen_queue' => $this->status->getListenQueue(),
            'max_active_processes' => $this->status->getMaxActiveProcesses(),
            'max_children_reached' => $this->status->getMaxChildrenReached(),
            'max_listen_queue_reached' => $this->status->getMaxListenQueue(),
            'slow_requests' => $this->status->getSlowRequests(),
            'start_since' => $this->status->getStartSince(),
            'total_processes' => $this->status->getTotalProcesses(),
            'requests_per_second' => $this->calcRequestsPerSec(),
            'max_usage' => $this->calcMaxProcessUsage()
        ];
    }

    /**
     *
     * @return float
     */
    protected function calcRequestsPerSec(): float
    {
        $conn = $this->status->getAcceptedConnections();
        $seconds = $this->status->getStartSince();

        if ($conn !== 0 && $seconds !== 0) {
            return round($conn / $seconds, 3);
        }

        return 0.0;
    }

    /**
     *
     * @return float
     */
    protected function calcMaxProcessUsage(): float
    {
        if ($this->config === null) {
            return 0.0;
        }

        $maxReached = $this->status->getMaxActiveProcesses();
        $maxPossible = $this->config->getMaxChildren();

        if ($maxReached !== 0 && $maxPossible !== 0) {
            return round(100 / ($maxPossible / $maxReached), 3);
        }

        return 0.0;
    }
}
