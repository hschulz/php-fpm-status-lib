<?php

namespace Hschulz\FpmStatus\Tests\Unit\Request;

use Hschulz\FpmStatus\Request\CurlStatus;
use PHPUnit\Framework\TestCase;

/**
 * Description of CurlStatusTest
 */
final class CurlStatusTest extends TestCase
{
    public function testMockGetUrl(): void
    {
        $stub = $this->getMockBuilder(CurlStatus::class)->getMock();
        $stub->expects($this->any())->method('get')->willReturn([]);

        $this->assertEquals([], $stub->get('https://example.org/status'));
    }

    public function testCloseCurlRessource(): void
    {
        $subject = new CurlStatus();

        $subject->open();
        $subject->close();

        unset($subject);

        $this->expectNotToPerformAssertions();
    }
}
