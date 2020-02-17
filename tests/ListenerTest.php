<?php
include __DIR__ . '/../vendor/autoload.php';

use PHPUnitFilterBlocker\Listener;

class ListenerTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $listener = new Listener();

        $this->assertTrue($listener->hasBeenSpecifiedTestCase());
        $this->assertFalse($listener->blockGroup());
        $this->assertFalse($listener->blockExcludeGroup());
    }

    public function testConstructWithArgs()
    {
        $listener = new Listener(['blockGroup' => true, 'blockExcludeGroup' => true]);

        $this->assertTrue($listener->hasBeenSpecifiedTestCase());
        $this->assertTrue($listener->blockGroup());
        $this->assertTrue($listener->blockExcludeGroup());
    }
}
