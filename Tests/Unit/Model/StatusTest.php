<?php

namespace Hschulz\FpmStatus\Tests\Unit\Model;

use Hschulz\FpmStatus\Model\Status;
use PHPUnit\Framework\TestCase;

/**
 * Description of StatusTest
 */
final class StatusTest extends TestCase
{
    public function testCanBeCreatedWithEmptyData(): void
    {
        $subject = new Status([]);

        $this->assertEquals(0, $subject->getAcceptedConnections());
        $this->assertEquals(0, $subject->getActiveProcesses());
        $this->assertEquals(0, $subject->getIdleProcesses());
        $this->assertEquals(0, $subject->getListenQueue());
        $this->assertEquals('', $subject->getManager());
        $this->assertEquals(0, $subject->getMaxActiveProcesses());
        $this->assertEquals(0, $subject->getMaxChildrenReached());
        $this->assertEquals(0, $subject->getMaxListenQueue());
        $this->assertEquals('', $subject->getPool());
        $this->assertEquals([], $subject->getProcesses());
        $this->assertEquals(0, $subject->getSlowRequests());
        $this->assertEquals(0, $subject->getStartSince());
        $this->assertEquals(0, $subject->getStartTime());
        $this->assertEquals(0, $subject->getTotalProcesses());
    }

    public function testCanSetProcesses(): void
    {
        $subject = new Status([
            Status::FIELD_PROCESSES => [
                []
            ]
        ]);

        $this->assertEquals(0, $subject->getAcceptedConnections());
        $this->assertEquals(0, $subject->getActiveProcesses());
        $this->assertEquals(0, $subject->getIdleProcesses());
        $this->assertEquals(0, $subject->getListenQueue());
        $this->assertEquals('', $subject->getManager());
        $this->assertEquals(0, $subject->getMaxActiveProcesses());
        $this->assertEquals(0, $subject->getMaxChildrenReached());
        $this->assertEquals(0, $subject->getMaxListenQueue());
        $this->assertEquals('', $subject->getPool());
        $this->assertCount(1, $subject->getProcesses());
        $this->assertEquals(0, $subject->getSlowRequests());
        $this->assertEquals(0, $subject->getStartSince());
        $this->assertEquals(0, $subject->getStartTime());
        $this->assertEquals(0, $subject->getTotalProcesses());
    }
}
