<?php

namespace startphp\Facade;

use startphp\Facade;

class Model extends Facade
{
    public static function setFacade () {
        return "\startphp\Model";
    }
}