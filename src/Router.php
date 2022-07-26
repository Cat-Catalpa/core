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

class Router
{
    public function init ()
    {
        $query_file = $_SERVER["REQUEST_URI"];
        if ($query_file == "/") $query_file = "/index";
        if (is_file (PUBLICDIR . substr ($query_file, 1))) {
            $finfo = finfo_open (FILEINFO_MIME_TYPE);
            $type = finfo_file ($finfo, PUBLICDIR . substr ($query_file, 1));
            echo file_get_contents (PUBLICDIR . substr ($query_file, 1));
            header ("Content-type: $type");
            header ("Content-Disposition: attachment; filename= " . basename (PUBLICDIR . substr ($query_file, 1)));
            set_time_limit (10);
            return false;
        }

        hook_getClassName ('routerInit')->transfer ([$query_file]);
        $hasBeenRun['router'] = " - Router_Init";
        global $route;

        if (!isset($route)) {
            $route = [];
            scan (ROUTE, true, function ($a) {
                global $route;
                $data = include ($a);
                $route = array_merge ($route, $data);
            });
        }
        return $query_file;
    }

    public function set ($url)
    {
        $query_file = $_SERVER["REQUEST_URI"];
        if ($query_file == "/") $query_file = "/index";
        global $hasBeenRun, $pageContent, $viewQueue;
        if(file_exists(APP.ucfirst($url['app']).".php")){
            require_once(APP.ucfirst($url['app']).".php");
            $class = "app\\".ucfirst($url['app'])."\Entrance\Entrance";
            $opinion = (new $class)->entrance($url) ?? true;
            if(is_file(APP.ucfirst($url['app']).".php") && $opinion == false){
                getClass("view")->setContent(\Template::getTemplateContent(config("access_denied_page","AccessDenied")))->setProtect();
            }
        }
        if (is_dir (APP . $url['app'] . DS . "config" . DS)) scan (APP . $url['app'] . DS . "config" . DS, true, function ($a, $v) {
            global $config, $url;
            $config = array_merge ($config, require_once (APP . $url['app'] . DS . "config" . DS . pathinfo ($v, PATHINFO_FILENAME) . ".php"));
        });
        getClass ("request")->setUrl($url);
        if(file_exists (APP . $url['app'] . DS . "controller" . $url['path'] . $url['controller'] . ".php"))
            require_once (APP . $url['app'] . DS . "controller" . $url['path'] . $url['controller'] . ".php");
        else \ThrowError::throw(__FILE__, __LINE__, "EC100020", $query_file);
        $className = "\\" . "app" . "\\" . $url["app"] . "\\" . "controller" . "\\" . $url["controller"];
        $class = new $className;
        if (method_exists ($class, $url['function'])) {
            $pageContent = call_user_func_array ([$class, $url['function']], [$url['vars']]);
            if (gettype ($pageContent) == "NULL") {
                \ThrowError::throw(__FILE__, __LINE__, "EC100009", $class . "=>" . $url['function']);
            }
        } elseif (method_exists ($class, "__call")) {
            $pageContent = call_user_func_array ([$class, '__call'], [$url['function'], $url['vars']]);
        } else {
            if(empty(config ('404_template',''))) \ThrowError::throw(__FILE__, __LINE__, "EC100010", $className . "=>" . $url['function']);
            else lockPage (\Template::getTemplateContent(config('404_template','')));
        }
        if (empty($viewQueue->getMainView ()->getContent ())) $viewQueue->getMainView ()->setContent ($pageContent);
        hook_getClassName ('afterRouter')->transfer ([$query_file, $url]);
        return $url;
    }
}