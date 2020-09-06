<?php

namespace Hschulz\FpmStatus\Tests\Unit\Model;

use Hschulz\FpmStatus\Model\PoolConfig;
use PHPUnit\Framework\TestCase;

/**
 * Description of PoolConfigTest
 */
final class PoolConfigTest extends TestCase
{
    public function testCanSetIdleTimeoutDefault(): void
    {
        $subject = new PoolConfig();

        $subject->setIdleTimeout('10');

        $this->assertEquals(10, $subject->getIdleTimeout());
    }

    public function testCanSetIdleTimeoutSeconds(): void
    {
        $subject = new PoolConfig();

        $subject->setIdleTimeout('30s');

        $this->assertEquals(30, $subject->getIdleTimeout());
    }

    public function testCanSetIdleTimeoutMinutes(): void
    {
        $subject = new PoolConfig();

        $subject->setIdleTimeout('45m');

        $this->assertEquals(2700, $subject->getIdleTimeout());
    }

    public function testCanSetIdleTimeoutHours(): void
    {
        $subject = new PoolConfig();

        $subject->setIdleTimeout('2h');

        $this->assertEquals(7200, $subject->getIdleTimeout());
    }

    public function testCanSetIdleTimeoutDays(): void
    {
        $subject = new PoolConfig();

        $subject->setIdleTimeout('7d');

        $this->assertEquals(604800, $subject->getIdleTimeout());
    }

    public function testCanSetMaxChildren(): void
    {
        $subject = new PoolConfig();

        $subject->setMaxChildren(50);

        $this->assertEquals(50, $subject->getMaxChildren());
    }

    public function testCanSetMaxRequests(): void
    {
        $subject = new PoolConfig();

        $subject->setMaxRequests(350);

        $this->assertEquals(350, $subject->getMaxRequests());
    }

    public function testCanSetMaxSpareServers(): void
    {
        $subject = new PoolConfig();

        $subject->setMaxSpareServers(40);

        $this->assertEquals(40, $subject->getMaxSpareServers());
    }

    public function testCanSetMinSpareServers(): void
    {
        $subject = new PoolConfig();

        $subject->setMinSpareServer(20);

        $this->assertEquals(20, $subject->getMinSpareServer());
    }
}
