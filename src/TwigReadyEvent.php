<?php

declare(strict_types=1);

namespace Jarvis\Skill\Twig;

use Jarvis\Skill\EventBroadcaster\PermanentEvent;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class TwigReadyEvent extends PermanentEvent
{
    const READY_EVENT = 'twig.ready';

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function twig(): \Twig_Environment
    {
        return $this->twig;
    }
}
