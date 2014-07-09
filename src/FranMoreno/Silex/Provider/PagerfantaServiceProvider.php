<?php

namespace FranMoreno\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Pagerfanta\View\DefaultView;
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\View\TwitterBootstrap3View;
use Pagerfanta\View\ViewFactory;
use FranMoreno\Silex\Service\PagerfantaFactory;
use FranMoreno\Silex\Twig\PagerfantaExtension;

class PagerfantaServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['pagerfanta.pager_factory'] = $app->share(function ($app) {
            return new PagerfantaFactory();
        });

        $app['pagerfanta.view.default_options'] = array(
            'routeName'        => null,
            'routeParams'      => array(),
            'pageParameter'    => '[page]',
            'proximity'        => 3,
            'next_message'     => '&raquo;',
            'previous_message' => '&laquo;',
            'default_view'     => 'default'
        );

        $app['pagerfanta.view_factory'] = $app->share(function ($app) {
            $defaultView = new DefaultView();
            $twitterBoostrapView = new TwitterBootstrapView();
            $twitterBoostrap3View = new TwitterBootstrap3View();

            $factoryView = new ViewFactory();
            $factoryView->add(array(
                $defaultView->getName() => $defaultView,
                $twitterBoostrapView->getName() => $twitterBoostrapView,
                $twitterBoostrap3View->getName() => $twitterBoostrap3View,
            ));

            return $factoryView;
        });

        if (isset($app['twig'])) {
            $app->extend('twig', function($twig, $app) {
                $ext = new PagerfantaExtension($app);
                if(!$twig->hasExtension($ext->getName())) {
                   $twig->addExtension($ext);
                }

                return $twig;
            });
        }
    }

    public function boot(Application $app)
    {
        $options = isset($app['pagerfanta.view.options']) ? $app['pagerfanta.view.options'] : array();
        $app['pagerfanta.view.options'] = array_replace($app['pagerfanta.view.default_options'], $options);
    }
}
