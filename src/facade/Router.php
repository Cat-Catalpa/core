<?php

namespace startphp\Facade\Router;

use startphp\Facade\Facade;

class Router extends Facade
{
    public static function setFacade () {
        return "\startphp\Router\Router";
    }
}