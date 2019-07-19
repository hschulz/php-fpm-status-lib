<?php

namespace Hschulz\FpmStatus\Tests\Unit\Model;

use \Hschulz\FpmStatus\Model\Process;
use \PHPUnit\Framework\TestCase;

/**
 * Description of ProcessTest
 */
final class ProcessTest extends TestCase
{
    public function testCanCreateNewInstanceFromEmptyData(): void
    {
        $data = [];

        $subject = new Process($data);

        $this->assertEquals(0, $subject->getContentLength());
        $this->assertEquals(0.0, $subject->getLastRequestCpu());
        $this->assertEquals(0, $subject->getLastRequestMemory());
        $this->assertEquals(0, $subject->getPid());
        $this->assertEquals(0, $subject->getRequestDuration());
        $this->assertEquals('', $subject->getRequestMethod());
        $this->assertEquals('', $subject->getRequestUri());
        $this->assertEquals(0, $subject->getRequests());
        $this->assertEquals('', $subject->getScript());
        $this->assertEquals(0, $subject->getStartSince());
        $this->assertEquals(0, $subject->getStartTime());
        $this->assertEquals('', $subject->getState());
        $this->assertEquals('', $subject->getUser());
    }

    public function testCanCreateNewInstanceWithData(): void
    {
        $data = [
            Process::FIELD_CONTENT_LENGTH => 1234,
            Process::FIELD_LAST_REQUEST_CPU => 24.25,
            Process::FIELD_LAST_REQUEST_MEMORY => 732,
            Process::FIELD_PID => 124,
            Process::FIELD_REQUESTS => 499,
            Process::FIELD_REQUEST_DURATION => 10,
            Process::FIELD_REQUEST_METHOD => 'POST',
            Process::FIELD_REQUEST_URI => '/',
            Process::FIELD_SCRIPT => 'index.php',
            Process::FIELD_START_SINCE => 34127,
            Process::FIELD_START_TIME => 243612346,
            Process::FIELD_STATE => 'idle',
            Process::FIELD_USER => 'test'
        ];

        $subject = new Process($data);

        $this->assertEquals(1234, $subject->getContentLength());
        $this->assertEquals(24.25, $subject->getLastRequestCpu());
        $this->assertEquals(732, $subject->getLastRequestMemory());
        $this->assertEquals(124, $subject->getPid());
        $this->assertEquals(499, $subject->getRequests());
        $this->assertEquals(10, $subject->getRequestDuration());
        $this->assertEquals('POST', $subject->getRequestMethod());
        $this->assertEquals('/', $subject->getRequestUri());
        $this->assertEquals('index.php', $subject->getScript());
        $this->assertEquals(34127, $subject->getStartSince());
        $this->assertEquals(243612346, $subject->getStartTime());
        $this->assertEquals('idle', $subject->getState());
        $this->assertEquals('test', $subject->getUser());
    }

    public function testCanSetContentLength(): void
    {
        $subject = new Process([]);

        $subject->setContentLength(12345);

        $this->assertEquals(12345, $subject->getContentLength());
    }

    public function testCanSetRequestCpu(): void
    {
        $subject = new Process([]);

        $subject->setLastRequestCpu(55.23);

        $this->assertEquals(55.23, $subject->getLastRequestCpu());
    }

    public function testCanSetLastRequestMemory(): void
    {
        $subject = new Process([]);

        $subject->setLastRequestMemory(45659);

        $this->assertEquals(45659, $subject->getLastRequestMemory());
    }

    public function testCanSetPid(): void
    {
        $subject = new Process([]);

        $subject->setPid(7777);

        $this->assertEquals(7777, $subject->getPid());
    }

    public function testCanSetRequests(): void
    {
        $subject = new Process([]);

        $subject->setRequests(99);

        $this->assertEquals(99, $subject->getRequests());
    }

    public function testCanGetRequestDuration(): void
    {
        $subject = new Process([]);

        $subject->setRequestDuration(23);

        $this->assertEquals(23, $subject->getRequestDuration());
    }

    public function testCanSetRequestMethod(): void
    {
        $subject = new Process([]);

        $subject->setRequestMethod('OPTIONS');

        $this->assertEquals('OPTIONS', $subject->getRequestMethod());
    }

    public function testCanSetRequestUri(): void
    {
        $subject = new Process([]);

        $subject->setRequestUri('/unit/test');

        $this->assertEquals('/unit/test', $subject->getRequestUri());
    }

    public function testCanSetScript(): void
    {
        $subject = new Process([]);

        $subject->setScript('main.php');

        $this->assertEquals('main.php', $subject->getScript());
    }

    public function testCanSetStartSince(): void
    {
        $subject = new Process([]);

        $subject->setStartSince(1337);

        $this->assertEquals(1337, $subject->getStartSince());
    }

    public function testCanSetStartTime(): void
    {
        $subject = new Process([]);

        $subject->setStartTime(3412641264);

        $this->assertEquals(3412641264, $subject->getStartTime());
    }

    public function testCanSetState(): void
    {
        $subject = new Process([]);

        $subject->setState('running');

        $this->assertEquals('running', $subject->getState());
    }

    public function testCanSetUser(): void
    {
        $subject = new Process([]);

        $subject->setUser('unit');

        $this->assertEquals('unit', $subject->getUser());
    }
}
