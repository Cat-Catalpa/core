<?php

namespace startphp\Facade;

use startphp\Facade;

class Router extends Facade
{
    public static function setFacade () {
        return "\startphp\Router";
    }
}