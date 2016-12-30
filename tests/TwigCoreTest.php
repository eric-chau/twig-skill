<?php

declare(strict_types=1);

use Jarvis\Jarvis;
use Jarvis\Skill\Twig\TwigCore;
use Jarvis\Skill\Twig\TwigReadyEvent;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class TwigCoreTest extends \PHPUnit_Framework_TestCase
{
    public function test_twig_service(): void
    {
        $settings = $this->getSettings();
        unset($settings['providers']);
        $app = new Jarvis($settings);

        $this->assertFalse(isset($app['twig']));

        $app->hydrate(new TwigCore());

        $this->assertTrue(isset($app['twig']));
        $this->assertInstanceOf(\Twig_Environment::class, $app['twig']);

        // unique instance test
        $this->assertSame($app['twig'], $app['twig']);
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage "templates_paths" parameter is missing to configure Twig.
     */
    public function test_throw_exception_on_missing_templates_paths_parameter(): void
    {
        $settings = $this->getSettings();
        unset($settings['extra']);
        $app = new Jarvis($settings);

        $app['twig'];
    }

    public function test_router_global_variable_exists()
    {
        $app = new Jarvis($this->getSettings());

        $globals = $app['twig']->getGlobals();

        $this->assertTrue(isset($globals['router']));
        $this->assertSame($app['router'], $globals['router']);
    }

    public function test_TwigReadyEvent_is_broadcasted_once_on_first_call(): void
    {
        $app = new Jarvis($this->getSettings());

        $receiver = $this->buildTwigReadyEventReceiver();
        $app->on(TwigReadyEvent::READY_EVENT, [$receiver, 'onTwigReadyEvent']);

        $this->assertSame(0, $receiver->callCount());

        $app['twig'];

        $this->assertSame(1, $receiver->callCount());

        $app['twig'];

        $this->assertSame(1, $receiver->callCount());
    }

    protected function getSettings(): array
    {
        return [
            'providers' => [
                TwigCore::class,
            ],
            'extra' => [
                'twig' => [
                    'templates_paths' => sys_get_temp_dir(),
                ],
            ],
        ];
    }

    protected function buildTwigReadyEventReceiver()
    {
        return new class {
            /**
             * @var int
             */
            private $callCount = 0;

            public function callCount(): int
            {
                return $this->callCount;
            }

            public function onTwigReadyEvent(TwigReadyEvent $event): void
            {
                $this->callCount++;
            }
        };
    }
}
