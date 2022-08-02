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

namespace startphp;

class Controller
{

    protected $version, $view, $template,$request,$database;

    function __construct ()
    {
        global $version, $viewQueue, $template,$database;
        $this->version = $version = VERSION;
        $this->view = getClass("view");
        $this->viewQueue = $viewQueue;
        $this->template = $template;
        $this->request = new \Request;
        $this->database = app()->database;
    }

    public function global ($vars)
    {
        return $GLOBALS[$vars];
    }

    public function getFileContent ($path, $returnContent = false)
    {
        $return = $this->view->getFileContent ($path, $returnContent);
        if (is_object ($return)) {
            return $this;
        } else {
            return $return;
        }
    }

    public function assign ($key, $value = "")
    {
        $this->view->assign ($key, $value);
        return $this;
    }

    public function render ($content = "")
    {
        $this->view->render ($content);
        return $this;
    }

    public function toggle ($cleanCache = true)
    {
        $this->view->toggle ($cleanCache);
        return $this;
    }

    public function filter ($content = "")
    {
        $this->view->filter ($content);
        return $this;
    }

    public function save ()
    {
        $this->view->save ();
        return $this;
    }

    public function setContent ($content)
    {
        $this->view->setContent ($content);
        return $this;
    }

}