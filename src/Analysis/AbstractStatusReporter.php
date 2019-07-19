<?php

namespace Hschulz\FpmStatus\Analysis;

use \Hschulz\FpmStatus\Analysis\StatusReporterInterface;
use \Hschulz\FpmStatus\Analysis\Performance\ManagerInterface;
use \Hschulz\FpmStatus\Model\Entry;
use \Hschulz\FpmStatus\Model\PoolConfig;
use \Hschulz\FpmStatus\Model\Report;
use \Hschulz\FpmStatus\Model\Status;
use function \sprintf;

/**
 * AbstractStatusReporter
 */
abstract class AbstractStatusReporter implements StatusReporterInterface
{
    /**
     *
     * @var Status
     */
    protected $status = null;

    /**
     *
     * @var Report
     */
    protected $report = null;

    /**
     *
     * @var PoolConfig
     */
    protected $config = null;

    /**
     *
     */
    public function __constructor()
    {
        $this->status = null;
        $this->report = null;
        $this->config = null;
    }

    /**
     *
     * @param Status $status
     * @param PoolConfig|null $config
     * @return Report
     */
    public function generate(Status $status, ?PoolConfig $config = null): Report
    {
        $this->status = $status;
        $this->config = $config;
        $this->report = new Report();

        $entries = [];

        $entries[] = $this->checkMaxChildren();
        $entries[] = $this->checkListenQueue();
        $entries[] = $this->checkMaxListenQueue();
        $entries[] = $this->checkSlowRequests();

        for ($i = 0; $i < 4; ++$i) {
            if ($entries[$i] !== null) {
                $this->report->add($entries[$i]);
            }
        }

        $this->report->add(new Entry('FPM is running'));

        $this->calcPerformance();

        return $this->report;
    }

    /**
     * This is a serious error.
     *
     * @return Entry|null
     */
    protected function checkMaxChildren(): ?Entry
    {
        if ($this->status->getMaxChildrenReached() === 0) {
            return null;
        }

        $entry = new Entry('Max children reached');
        $entry->setPriority(Entry::PRIORITY_HIGHEST);
        $entry->setStatus(Entry::STATUS_ERROR);

        return $entry;
    }

    /**
     * This is also a serious error.
     *
     * @return Entry|null
     */
    protected function checkListenQueue(): ?Entry
    {
        if ($this->status->getListenQueue() === 0) {
            return null;
        }

        $entry = new Entry('Listen queue is not empty');
        $entry->setPriority(Entry::PRIORITY_HIGHEST);
        $entry->setStatus(Entry::STATUS_ERROR);

        return $entry;
    }

    /**
     * This should at least be a warning.
     *
     * @return Entry|null
     */
    protected function checkMaxListenQueue(): ?Entry
    {
        if ($this->status->getMaxListenQueue() === 0) {
            return null;
        }

        $entry = new Entry('Listen queue maximum value was reached');
        $entry->setPriority(Entry::PRIORITY_HIGH);
        $entry->setStatus(Entry::STATUS_ERROR);

        return $entry;
    }

    /**
     * Slow requests are defintively a warning.
     *
     * @return Entry|null
     */
    protected function checkSlowRequests(): ?Entry
    {
        if ($this->status->getSlowRequests() === 0) {
            return null;
        }

        $entry = new Entry('Slow requests are currently present');
        $entry->setPriority(Entry::PRIORITY_MEDIUM);
        $entry->setStatus(Entry::STATUS_ERROR);

        return $entry;
    }

    /**
     *
     * @return void
     */
    protected function calcPerformance(): void
    {
        $type = ucfirst($this->status->getManager());

        $fqns = '\\' . __NAMESPACE__ . '\\Performance\\' . $type . 'Manager';

        if (!class_exists($fqns)) {

            $message = sprintf('Manager for type "%s" not found', $type);

            $this->report->add(new Entry($message, Entry::STATUS_ERROR, Priority::HIGH));
            return;
        }

        /* @var $manager ManagerInterface */
        $manager = new $fqns($this->status, $this->config);

        $this->report->setPerformance($manager->getPerformance($this->status, $this->config));
    }
}
