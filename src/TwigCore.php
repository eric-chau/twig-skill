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
    public function hydrate(Jarvis $app)
    {
        $app['twig'] = function (Jarvis $app): \Twig_Environment {
            $settings = array_merge([
                'auto_reload'      => true,
                'debug'            => $app['debug'],
                'strict_variables' => true,
            ], (array) ($app['twig.settings'] ?? []));

            if (!isset($settings['templates_paths'])) {
                throw new \LogicException('Parameter `templates_paths` is missing to configure Twig.');
            }

            $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($settings['templates_paths']), $settings);
            $app->broadcast(TwigReadyEvent::READY_EVENT, new TwigReadyEvent($twig));

            return $twig;
        };

        $app->lock('twig');
    }
}
