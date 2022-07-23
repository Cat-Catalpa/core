<?php

namespace startphp\Facade\Model;

use startphp\Facade\Facade;

class Model extends Facade
{
    public static function setFacade () {
        return "\startphp\Model\Model";
    }
}