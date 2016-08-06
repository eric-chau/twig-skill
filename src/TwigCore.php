<?php

namespace Jarvis\Skill\Twig;

use Jarvis\Jarvis;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class TwigCore implements ContainerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $jarvis)
    {
        $jarvis['twig'] = function(Jarvis $jarvis) {
            $config = array_merge(
                [
                    'auto_reload'      => true,
                    'debug'            => $jarvis->debug,
                    'strict_variables' => true,
                ],
                $jarvis->settings->get('twig', [])
            );

            if (!isset($config['templates_paths'])) {
                throw new \LogicException('Parameter `templates_paths` is missing to configure Twig.');
            }

            $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($config['templates_paths']), $config);

            $jarvis->broadcast(TwigReadyEvent::READY_EVENT, new TwigReadyEvent($twig));

            return $twig;
        };

        $jarvis->lock('twig');
    }
}
