<?php

declare(strict_types=1);

use Jarvis\Skill\EventBroadcaster\PermanentEvent;
use Jarvis\Skill\Twig\TwigReadyEvent;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class TwigReadyEventTest extends \PHPUnit_Framework_TestCase
{
    public function test_is_permanent_event()
    {
        $twig = $this
            ->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $event = new TwigReadyEvent($twig);

        $this->assertInstanceOf(PermanentEvent::class, $event);
        $this->assertTrue($event->isPermanent());
    }
}
