<?php

namespace FranMoreno\Silex\Twig;

use Silex\Application;
use Symfony\Component\Form\Util\PropertyPath;
use Pagerfanta\PagerfantaInterface;

class PagerfantaExtension extends \Twig_Extension
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getFunctions()
    {
        return array(
            'pagerfanta' => new \Twig_Function_Method($this, 'renderPagerfanta', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a pagerfanta.
     *
     * @param PagerfantaInterface $pagerfanta The pagerfanta.
     * @param string              $viewName   The view name.
     * @param array               $options    An array of options (optional).
     *
     * @return string The pagerfanta rendered.
     */
    public function renderPagerfanta(PagerfantaInterface $pagerfanta, $viewName = null, array $options = array())
    {
        $options = array_replace($this->app['pagerfanta.view.options'], $options);

        if (null === $viewName) {
            $viewName = $options['default_view'];
        }

        $router = $this->app['url_generator'];

        if (null === $options['routeName']) {
            $request = $this->app['request'];

            $options['routeName'] = $request->attributes->get('_route');
            $options['routeParams'] = array_merge($request->query->all(), $request->attributes->get('_route_params'));
        }

        $routeName = $options['routeName'];
        $routeParams = $options['routeParams'];
        $pagePropertyPath = new PropertyPath($options['pageParameter']);
        $routeGenerator = function($page) use($router, $routeName, $routeParams, $pagePropertyPath) {
            $pagePropertyPath->setValue($routeParams, $page);
            return $router->generate($routeName, $routeParams);
        };

        return $this->app['pagerfanta.view_factory']->get($viewName)->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pagerfanta';
    }
}
