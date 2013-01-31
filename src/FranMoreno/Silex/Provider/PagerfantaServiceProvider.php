<?php

namespace FranMoreno\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Pagerfanta\View\DefaultView;
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\View\ViewFactory;

use FranMoreno\Silex\Twig\PagerfantaExtension;

class PagerfantaServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['pagerfanta.view_factory'] = $app->share(function ($app) {
            $defaultView = new DefaultView();
            $twitterBoostrapView = new TwitterBootstrapView();

            $factoryView = new ViewFactory();
            $factoryView->add(array(
                $defaultView->getName() => $defaultView,
                $twitterBoostrapView->getName() => $twitterBoostrapView
            ));

            return $factoryView;
        });
    }

    public function boot(Application $app)
    {
        if (isset($app['twig'])) {
            $app['twig']->addExtension(new PagerfantaExtension($app));
        }
    }
}
