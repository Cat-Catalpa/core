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

class Boot extends Container
{
    protected $inited = false;

    protected $startTime = 0;

    protected $startMemory = 0;

    protected $language = "";

    protected $logo = [
        'app'             => Boot::class,
        'cookie'          => Cookie::class,
        'database'        => Database::class,
        'env'             => Env::class,
        'hook'            => Hook::class,
        'lang'            => Language::class,
        'log'             => Log::class,
        'model'           => Model::class,
        'redirect'        => Redirect::class,
        'request'         => Request::class,
        'response'        => Response::class,
        'route'           => Route::class,
        'router'          => Router::class,
        'session'         => Session::class,
        'template'        => Template::class,
        'throwError'      => ThrowError::class,
        'view'            => View::class,
        'viewQueue'       => ViewQueue::class,
    ];

    function __construct ()
    {
        //引入全局变量
        global $vendorDir, $memoryAnalysis, $viewQueue, $url;

        //检查框架核心代码是否存在
        if (!is_dir ($vendorDir . DIRECTORY_SEPARATOR . "catcatalpa" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "src"))
            $this->coreMissing ();

        //将自身注入到容器中，用于依赖注入
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance('container', $this);

        //记录所有输出，以便在错误捕获后清空页面所有已渲染元素
        ob_start ();
    }

    public function Init ()
    {

        global $baseDir, $hasBeenRun, $viewQueue, $memoryAnalysis, $lang;

        //记录系统初始化状态
        if ($this->inited) return false;
        else $this->inited = true;

        //记录系统启动信息
        $this->startTime = microtime (true);
        $this->startMemory = memory_get_usage ();

        //引入系统全局配置
        require_once $baseDir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'Config.php';

        $request = $this->newInstance ("request",true);


        //引入环境变量
        if(file_exists (ROOT.".env")){
            $this->env->loadFile();
        }

        //注册生命钩子机制
        require_once DIR. "Hook.php";

        //注册框架自动加载机制
        require_once DIR . "Autoload.php";

        //定义全局语言
        $lang = ($langClass = $this->lang)->load();
        $this->instance ("lang",$langClass);

        //注册调试模式日志输出机制
        $memoryAnalysis = new \startphp\DevDebug();

        //记录系统状态
        $hasBeenRun['init'] = " - System_Init";

        //监听App_Init
        \Hook::getClassName('appInit')->transfer ();

        //注册助手函数
        require_once DIR . "Helper.php";

        //注册系统错误捕获机制
        \startphp\Error::init ();

        //注册View队列
        $viewQueue = $this->viewQueue->init($view = $this->view,"systemView");
        $this->instance('viewQueue',$viewQueue);

        return $this;
    }

    public function runMain ()
    {

        $this->database = new \startphp\Database(
            env('database.type',"mysql"),
            env('database.host',"127.0.0.1"),
            env('database.name',""),
            env('database.user',"rott"),
            env('database.pass',""),
            env('database.port',"3306"),
            env('database.prefix',""),
            env('database.file',""),
            env('database.table',"")
        );

        //初始化路由解析机制
        parseGlobalUrl (true);

        return $this->getClass ("response");
    }

    public function coreMissing ()
    {
        global $vendorDir;
        die("<title>Framework self-test failed - 框架自检失败</title><h2>Framework self-test failed - 框架自检失败</h2><br>
            <b>Fatal Error:</b> The framework core code (<b><u>$vendorDir" . DIRECTORY_SEPARATOR . "catcatalpa" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "src</b></u>) 
            does not exist, please check whether the framework resources are complete, 
           if not, please execute the 'composer update' command to supplement the framework dependency files.<br>
            <b>致命错误:</b> 框架核心代码（<b><u>$vendorDir" . DIRECTORY_SEPARATOR . "catcatalpa" . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "src</b></u>）不存在，
            请检查框架资源是否完整，若不完整，请执行'composer update'命令来补充框架依赖文件");
    }

    public function end ()
    {
        global $memoryAnalysis;
        //系统启动完成
        $hasBeenRun['end'] = " - System_Init_End";
        hook_getClassName ("appDestroy")->transfer ([$memoryAnalysis]);
        if (env ('system.debug.mode', false) || config('print_system_status',false)) {
            $memoryAnalysis->output ();
        }
    }
}