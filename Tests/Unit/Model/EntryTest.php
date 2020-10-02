<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Tests\Unit\Model;

use Hschulz\FpmStatus\Model\Entry;
use PHPUnit\Framework\TestCase;

/**
 * Description of EntryTest
 */
final class EntryTest extends TestCase
{
    public function testCanCreateNewFullInstance(): void
    {
        $subject = new Entry('Unit test', 2, 66);

        $this->assertEquals('Unit test', $subject->getMessage());
        $this->assertEquals(2, $subject->getStatus());
        $this->assertEquals(66, $subject->getPriority());
    }

    public function testCanSetMessage(): void
    {
        $subject = new Entry('Unit Test');

        $subject->setMessage('Updated message');

        $this->assertEquals('Updated message', $subject->getMessage());
    }

    public function testCanSetStatus(): void
    {
        $subject = new Entry('Test');

        $subject->setStatus(1);

        $this->assertEquals(1, $subject->getStatus());
    }

    public function testCanSetPriority(): void
    {
        $subject = new Entry('Test');

        $subject->setPriority(33);

        $this->assertEquals(33, $subject->getPriority());
    }
}
