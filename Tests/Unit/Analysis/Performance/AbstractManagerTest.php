<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Tests\Unit\Analysis\Performance;

use Hschulz\FpmStatus\Analysis\Performance\AbstractManager;
use Hschulz\FpmStatus\Model\PoolConfig;
use Hschulz\FpmStatus\Model\Status;
use PHPUnit\Framework\TestCase;

/**
 * Description of AbstractManagerTest
 *
 * @author Hauke Schulz
 */
final class AbstractManagerTest extends TestCase
{
    public function testReturnsSaneValuesForMockImplementation(): void
    {
        $subject = $this->getMockForAbstractClass(AbstractManager::class);

        $result = $subject->getPerformanceData(new Status([]));

        $this->assertIsArray($result);

        $this->assertEquals($result['accepted_connections'], 0);
        $this->assertEquals($result['active_processes'], 0);
        $this->assertEquals($result['idle_processes'], 0);
        $this->assertEquals($result['listen_queue'], 0);
        $this->assertEquals($result['max_active_processes'], 0);
        $this->assertEquals($result['max_children_reached'], 0);
        $this->assertEquals($result['max_listen_queue_reached'], 0);
        $this->assertEquals($result['slow_requests'], 0);
        $this->assertEquals($result['start_since'], 0);
        $this->assertEquals($result['total_processes'], 0);
        $this->assertEquals($result['requests_per_second'], 0.0);
        $this->assertEquals($result['max_usage'], 0.0);
    }

    public function testReturnsCorrectRequestsPerSecond(): void
    {
        $subject = $this->getMockForAbstractClass(AbstractManager::class);

        $result = $subject->getPerformanceData(new Status([
            Status::FIELD_ACCEPTED_CONN => 1000,
            Status::FIELD_START_SINCE => 500
        ]));

        $this->assertIsArray($result);

        $this->assertEquals($result['accepted_connections'], 1000);
        $this->assertEquals($result['active_processes'], 0);
        $this->assertEquals($result['idle_processes'], 0);
        $this->assertEquals($result['listen_queue'], 0);
        $this->assertEquals($result['max_active_processes'], 0);
        $this->assertEquals($result['max_children_reached'], 0);
        $this->assertEquals($result['max_listen_queue_reached'], 0);
        $this->assertEquals($result['slow_requests'], 0);
        $this->assertEquals($result['start_since'], 500);
        $this->assertEquals($result['total_processes'], 0);
        $this->assertEquals($result['requests_per_second'], 2.0);
        $this->assertEquals($result['max_usage'], 0.0);
    }

    public function testMaxProcessesReached(): void
    {
        $subject = $this->getMockForAbstractClass(AbstractManager::class);

        $config = new PoolConfig();
        $config->setMaxChildren(500);

        $result = $subject->getPerformanceData(new Status([
            Status::FIELD_MAX_ACTIVE_PROCESSES => 500
        ]), $config);

        $this->assertIsArray($result);

        $this->assertEquals($result['accepted_connections'], 0);
        $this->assertEquals($result['active_processes'], 0);
        $this->assertEquals($result['idle_processes'], 0);
        $this->assertEquals($result['listen_queue'], 0);
        $this->assertEquals($result['max_active_processes'], 500);
        $this->assertEquals($result['max_children_reached'], 0);
        $this->assertEquals($result['max_listen_queue_reached'], 0);
        $this->assertEquals($result['slow_requests'], 0);
        $this->assertEquals($result['start_since'], 0);
        $this->assertEquals($result['total_processes'], 0);
        $this->assertEquals($result['requests_per_second'], 0.0);
        $this->assertEquals($result['max_usage'], 100.0);
    }

    public function testWithEmptyPoolConfig(): void
    {
        $subject = $this->getMockForAbstractClass(AbstractManager::class);

        $result = $subject->getPerformanceData(new Status([]), new PoolConfig());

        $this->assertIsArray($result);

        $this->assertEquals($result['accepted_connections'], 0);
        $this->assertEquals($result['active_processes'], 0);
        $this->assertEquals($result['idle_processes'], 0);
        $this->assertEquals($result['listen_queue'], 0);
        $this->assertEquals($result['max_active_processes'], 0);
        $this->assertEquals($result['max_children_reached'], 0);
        $this->assertEquals($result['max_listen_queue_reached'], 0);
        $this->assertEquals($result['slow_requests'], 0);
        $this->assertEquals($result['start_since'], 0);
        $this->assertEquals($result['total_processes'], 0);
        $this->assertEquals($result['requests_per_second'], 0.0);
        $this->assertEquals($result['max_usage'], 0.0);
    }
}
