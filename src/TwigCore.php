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
    public function hydrate(Jarvis $container)
    {
        $container['twig'] = function (Jarvis $container) {
            $config = array_merge(
                [
                    'auto_reload'      => true,
                    'debug'            => $container->debug,
                    'strict_variables' => true,
                ],
                $container->settings->get('twig', [])
            );

            if (!isset($config['templates_paths'])) {
                throw new \LogicException('Parameter `templates_paths` is missing to configure Twig.');
            }

            $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($config['templates_paths']), $config);

            $container->broadcast(TwigEvents::INIT_EVENT, new TwigEvent($twig));

            return $twig;
        };

        $container->lock('twig');
    }
}