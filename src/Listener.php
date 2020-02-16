<?php
namespace PHPUnitFilterBlocker;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;

class Listener implements TestListener
{
    use TestListenerDefaultImplementation;

    private $hasBeenSpecifiedTestCase = true;

    private $blockGroup = false;

    private $blockExcludeGroup = false;

    /**
     * Construct Listener instance
     *
     * @param mixed[] $options Array of arguments from phpunit.xml
     *
     * @return PHPUnitFilterBlocker\Listener
     */
    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->blockGroup = isset($options['blockGroup']) ? $options['blockGroup'] : false;
            $this->blockExcludeGroup = isset($options['blockExcludeGroup']) ? $options['blockExcludeGroup'] : false;
        }
    }

    /**
     * Getter of hasBeenSpecifiedTestCase
     *
     * @return boolean
     */
    public function hasBeenSpecifiedTestCase()
    {
        return $this->hasBeenSpecifiedTestCase;
    }

    /**
     * Getter of blockGroup
     *
     * @return boolean
     */
    public function blockGroup()
    {
        return $this->blockGroup;
    }

    /**
     * Getter of blockExcludeGroup
     *
     * @return boolean
     */
    public function blockExcludeGroup()
    {
        return $this->blockExcludeGroup;
    }

    /**
     * Implementation of startTestSuite
     *
     * @param \PHPUnit_Framework_TestSuite $suite TestSuite instance
     */
    public function startTestSuite(\PHPUnit\Framework\TestSuite $suite): void
    {
        if ($this->hasBeenSpecifiedTestCase() && class_exists($suite->getName(), false)) {
            printf("Test case specification has been disabled by phpunit-filter-blocker. Stopped phpunit.\n");
            exit(1);
        }

        $this->hasBeenSpecifiedTestCase = false;

        if (get_class($suite->getIterator()) === 'PHPUnit\Runner\Filter\NameFilterIterator') {
            printf("--filter option has been disabled by phpunit-filter-blocker. Stopped phpunit.\n");
            exit(1);
        }
        if ($this->blockGroup() && get_class($suite->getIterator()) === 'PHPUnit\Runner\Filter\IncludeGroupFilterIterator') {
            printf("--group option has been disabled by phpunit-filter-blocker. Stopped phpunit.\n");
            exit(1);
        }
        if ($this->blockExcludeGroup() && get_class($suite->getIterator()) === 'PHPUnit\Runner\Filter\ExcludeGroupFilterIterator') {
            printf("--group option has been disabled by phpunit-filter-blocker. Stopped phpunit.\n");
            exit(1);
        }
    }
}
