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

namespace startphp\ViewQueue;

use startphp\View\View;

class ViewQueue
{
    protected $queue = [];
    protected $mainView;
    protected $viewName;

    function __construct (View $view, $name)
    {
        $this->queue[$name] = $view;
        $this->mainView = $view;
    }

    public function get ($name)
    {
        return $this->queue[$name];
    }

    public function getQueue (): array
    {
        return $this->queue;
    }

    public function getMainView (): View
    {
        return $this->mainView;
    }

    public function getViewName ($view, $returnSelf = false)
    {
        if ($returnSelf) {
            $this->viewName = array_search ($view, $this->queue);
            return $this;
        }
        return array_search ($view, $this->queue);
    }

    public function getView ($name)
    {
        return $this->queue[$name];
    }

    public function create ($name)
    {
        $this->queue[$name] = new View();
    }

    public function set ($name, $view)
    {
        $this->queue[$name] = $view;
        return isset($this->queue[$name]);
    }

    public function setMainView ($view)
    {
        if(is_object ($view)) {
            $this->mainView = $view;
            return true;
        }
        else {
            $this->mainView = !is_bool ($result = array_search ($view, $this->queue)) ? $result : \ThrowError::throw(__FILE__, __LINE__, "EC100011", $view);
            return true;
        }
    }

    public function toggle ($targetView)
    {
        $this->getMainView ()->save ();
        $this->mainView = $targetView;
        $targetView->toggle ();
    }

    public function delete ($name = "")
    {
        if (empty($name)) $name = $this->viewName;
        if (empty($name)) \ThrowError::throw(__FILE__, __LINE__, "EC1000012");
        unset($this->queue[$name]);
    }
}