<?php
/*
 * +----------------------------------------------------------------------
 * | StartPHP Framework
 * +----------------------------------------------------------------------
 * | Copyright (c) 20021~2022 Cat Catalpa Vitality All rights reserved.
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Email: company@catcatalpa.com
 * +----------------------------------------------------------------------
 */

namespace startphp\format;

use startphp\Response;

class View extends Response
{

    protected $view;

    public function __construct ($view,$content,$code = 200) {
        $this->init($content,$code);
        $this->view = $view;
    }

    public function print ($content = "")
    {
        if(empty($content)) $content = $this->content;
        $this->filter ($this->content);
        echo $this->content;
    }

    public function filter ($content = "")
    {
        if(empty($content)) $content = $this->content;
        return $this->view->filter($content)->render("%self%",$this);
    }

}