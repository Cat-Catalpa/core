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

namespace startphp\Request;

use startphp\Facade\ParseUrl\ParseUrl;

class Request
{

    protected $server = [];

    protected $method = 'GET';

    protected $post = [];

    protected $get = [];

    protected $request = [];

    protected $files = [];

    protected $session = [];

    protected $cookie = [];

    protected $host = "";

    protected $port = 0;

    protected $domain = "";

    protected $controller = "";

    protected $controllerPath = "";

    protected $controllerApp = "";

    protected $url = "";

    protected $scheme = "";

    protected $controllerClass = "";

    protected $controllerFunction = "";

    protected $controllerArgs = "";

    protected $env = "";

    protected $config = "";

    protected $global = "";

    protected $httpUserAgent = "";

    protected $requestMethod = "";

    protected $userPLATFORM = "";

    protected $remotePort = 0;

    protected $requestUrl = "";

    public function __construct ()
    {
        global $config, $url;

        $this->server = $_SERVER;

        $this->method = $this->server['REQUEST_METHOD'];

        $this->post = $_POST;

        $this->get = $_GET;

        $this->config = $config;

        $this->env = $_ENV;

        $this->request = $_REQUEST;

        $this->files = $_FILES;

        $this->domain = $this->server['HTTP_HOST'];

        $this->port = $this->server['SERVER_PORT'];

        $this->httpUserAgent = $this->server['HTTP_USER_AGENT'];

        $this->requestMethod = $this->server['REQUEST_METHOD'];

        $this->userPLATFORM = $this->server['HTTP_USER_AGENT'];

        $this->remotePort = $this->server['REMOTE_PORT'];

        $this->requestUrl = $this->server['REQUEST_URI'];

        $this->scheme = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        if (empty($url)) {
            $url = parseUrl ($this->requestUrl);
        }

        $this->controller = $url['controller'];

        $this->controllerApp = $url['app'];

        $this->controllerPath = $url['app'];

        $this->controllerClass = ucfirst ($url['controller']);

        $this->controllerFunction = $url['function'];

        $this->controllerArgs = $url['vars'];

        if (!is_null ($this->controllerArgs)) {
            $arg = [];
            foreach ($url['vars'] as $key => $value) {
                if(empty($value)) $arg = array_merge ($arg,["$key"]);
                else $arg = array_merge ($arg, ["$key=$value"]);
            }
            $arg = implode ("&", $arg);
        } else $arg = "";

        $this->url = $this->scheme . $this->domain . "/" . $this->controllerApp . "/" . $this->controllerPath . "/" . $this->controller;

        $this->url .= empty($arg) ? "" : "?" . $arg;

        if (session_status () === PHP_SESSION_ACTIVE) $this->session = $_SESSION;

        $this->cookie = $_COOKIE;

        $this->env = array_merge ($this->env, $_ENV);

    }

    public function __call ($name, $arguments)
    {
        global $config;
        $this->env = $config;
        $this->global = $GLOBALS;
        if (function_exists ($name)) {
            call_user_func_array ($name, $arguments);
        } else {
            /** @var TYPE_NAME $returnText */
            eval("\$returnText = \$this->$name;");
            return $returnText;
        }
        return 0;
    }

    public function args ($returnString = false)
    {
        global $url;
        if (!$returnString) return $this->controllerArgs;
        if (!is_null ($this->controllerArgs)) {
            $arg = [];
            foreach ($url['vars'] as $key => $value) {
                $arg = array_merge ($arg, ["$key=$value"]);
            }
            return implode ("&", $arg);
        }
        return "";
    }
}
