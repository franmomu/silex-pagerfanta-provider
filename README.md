## PagerfantaServiceProvider

Provider to use [Pagerfanta](https://github.com/whiteoctober/Pagerfanta) with [Silex](https://github.com/fabpot/Silex)

This Provider is based on [WhiteOctoberPagerfantaBundle](https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle) and includes:
  * Twig function to render pagerfantas with views and options.
  * Way to use easily views.
  * Way to reuse options in views.

#### Registering

```
$app->register(new FranMoreno\Silex\Provider\PagerfantaServiceProvider());
```

#### Parameters

This are the default parameters:

```
$app['pagerfanta.view.options'] = array(
    'routeName'     => null,
    'routeParams'   => array(),
    'pageParameter' => '[page]',
    'proximity'     => 3,
    'next_message'  => '&raquo;',
    'prev_message'  => '&laquo;',
    'default_view'  => 'default'
);
```
