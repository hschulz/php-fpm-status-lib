<?php

declare(strict_types=1);

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
        $stub = $this->createMock(CurlStatus::class);
        $stub->expects($this->any())->method('getArray')->willReturn([]);

        $this->assertEquals([], $stub->getArray('https://example.org/status'));
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
