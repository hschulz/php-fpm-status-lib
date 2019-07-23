<?php

namespace Hschulz\FpmStatus\Analysis;

use \Hschulz\FpmStatus\Model\PoolConfig;
use \Hschulz\FpmStatus\Model\Report;
use \Hschulz\FpmStatus\Model\Status;

/**
 * StatusReporterInterface
 */
interface StatusReporterInterface
{
    /**
     *
     * @param Status $status
     * @param PoolConfig|null $config
     * @return Report
     */
    public function generate(Status $status, ?PoolConfig $config = null);
}
