<?php

namespace Hschulz\FpmStatus\Model;

use \Hschulz\FpmStatus\Model\Entry;
use function \array_search;

/**
 * Description of Report
 */
class Report
{
    /**
     *
     * @var array
     */
    protected $entries = [];

    /**
     *
     * @var array
     */
    protected $performance = [];

    /**
     *
     */
    public function __construct()
    {
        $this->entries = [];
        $this->performance = [];
    }

    /**
     *
     * @param Entry $entry
     * @return void
     */
    public function add(Entry $entry): void
    {
        $this->entries[$entry->getPriority()][$entry->getStatus()][] = $entry;
    }

    /**
     *
     * @param Entry $entry
     * @return void
     */
    public function remove(Entry $entry): void
    {
        $result = array_search($entry, $this->entries. true);

        if ($result !== false) {
            unset($this->entries[$result]);
        }
    }

    /**
     *
     * @return array
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     *
     * @param array $entries
     * @return void
     */
    public function setEntries(array $entries): void
    {
        $this->entries = $entries;
    }

    /**
     *
     * @return array
     */
    public function getPerformance(): array
    {
        return $this->performance;
    }

    /**
     *
     * @param array $performance
     * @return void
     */
    public function setPerformance(array $performance): void
    {
        $this->performance = $performance;
    }
}
