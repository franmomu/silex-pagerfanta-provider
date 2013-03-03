<?php

namespace FranMoreno\Silex\Service;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

class PagerfantaFactory
{
    public function getForArray($array)
    {
        $adapter = new ArrayAdapter($array);

        return new Pagerfanta($adapter);
    }
}