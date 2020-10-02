<?php

declare(strict_types=1);

namespace Hschulz\FpmStatus\Tests\Unit\Model;

use Hschulz\FpmStatus\Model\Entry;
use Hschulz\FpmStatus\Model\Report;
use PHPUnit\Framework\TestCase;

/**
 * Description of StatusTest
 */
final class ReportTest extends TestCase
{
    public function testEmptyReport(): void
    {
        $subject = new Report();

        $entries = $subject->getEntries();
        $performance = $subject->getPerformance();

        $this->assertIsArray($entries);
        $this->assertEmpty($entries);

        $this->assertIsArray($performance);
        $this->assertEmpty($performance);
    }

    public function testCanReplaceWithEmptyData(): void
    {
        $subject = new Report();

        $subject->setEntries([]);
        $subject->setPerformance([]);

        $entries = $subject->getEntries();
        $performance = $subject->getPerformance();

        $this->assertIsArray($entries);
        $this->assertEmpty($entries);

        $this->assertIsArray($performance);
        $this->assertEmpty($performance);
    }

    public function testCanAddEntry(): void
    {
        $subject = new Report();

        $entry = new Entry('Unit Test');

        $subject->add($entry);

        $result = $subject->getEntries();

        $this->assertIsArray($result);
        $this->assertEquals(1, count($result));
        $this->assertArrayHasKey(Entry::PRIORITY_LOWEST, $result);

        $this->assertIsArray($result[Entry::PRIORITY_LOWEST]);
        $this->assertEquals(1, count($result[Entry::PRIORITY_LOWEST]));
        $this->assertArrayHasKey(Entry::STATUS_OK, $result[Entry::PRIORITY_LOWEST]);

        $this->assertEquals($entry, $result[Entry::PRIORITY_LOWEST][Entry::STATUS_OK][0]);
    }

    public function testCanRemoveEntry(): void
    {
        $subject = new Report();

        $entry = new Entry('Unit Test');

        $subject->add($entry);

        $result = $subject->getEntries();

        $this->assertIsArray($result);
        $this->assertEquals(1, count($result));

        $subject->remove($entry);

        $newResult = $subject->getEntries();

        $this->assertIsArray($newResult);
        $this->assertEmpty($newResult);
    }
}
