<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Twig;

use Jarvis\Skill\EventBroadcaster\SimpleEvent;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class TwigEvent extends SimpleEvent
{
    const READY_EVENT = 'twig.ready';

    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function twig()
    {
        return $this->twig;
    }
}
