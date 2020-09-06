<?php

namespace Hschulz\FpmStatus\Analysis\Performance;

use Hschulz\FpmStatus\Model\PoolConfig;
use Hschulz\FpmStatus\Model\Status;

/**
 *
 */
interface ManagerInterface
{
    /**
     *
     * @param Status $status
     * @param PoolConfig|null $poolConfig
     * @return array
     */
    public function getPerformanceData(Status $status, ?PoolConfig $poolConfig = null): array;
}
