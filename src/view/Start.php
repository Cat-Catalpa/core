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

namespace startphp\View\Start;

class Start
{
    public $fileContent = "";
    protected $url = [];
    protected $data = [];
    protected $replaceText;
    protected $outputOpinion = "";
    protected $output = false;
    protected $saveResult = false;
    protected $subscript = "";

    public function parse ($fileContent, $data)
    {
        global $url;
        global $hasBeenRun;
        if(empty($fileContent)) return "";
        $this->data = $data;
        $hasBeenRun['tpl'] = " - Template_Engine_Init";
        $this->url = $url;
        hook_getClassName ('beforeParseFile')->transfer ([$this->fileContent]);
        $this->fileContent = $fileContent;
        $this->parseInclude ();
        $this->parseController ();
        $this->parseModel ();
        $this->parseFunction();
        $this->parseIf ();
        $this->parseVars ();
        hook_getClassName ('afterParseFile')->transfer ([$this->fileContent]);
        return $this->fileContent;
    }

    protected function parseInclude ()
    {
        $isMatched = preg_match_all ('/({{include=)(.)*?(}})/', $this->fileContent, $matches);
    }

    protected function parseController ()
    {
        $isMatched = preg_match_all ('/{{controller=.*?}}/', trim ($this->fileContent), $matches);
        if ($isMatched != 0) {
            for ($i = 0; $i < count ($matches, 1) - 1; $i++) {
                $funcName = preg_replace ('/({{controller=)(.*?)(}})/', '$2', $matches[0][$i]);
                $this->fileContent = str_replace ($matches[0], "", $this->fileContent);
                $className = "\\app\\" . $this->url['app'] . "\\" . ucfirst ($funcName) . "\\" . ucfirst ($funcName);
                $class = new $className;
                call_user_func_array ([$class, $funcName], [$this->url['vars']]);
            }
        }
    }

    protected function parseModel ()
    {
        $isMatched = preg_match_all ('/{{model=.*?}}/', trim ($this->fileContent), $matches);
        if ($isMatched != 0) {
            for ($i = 0; $i < count ($matches, 1) - 1; $i++) {
                $funcName = preg_replace ('/({{model=)(.*?)(}})/', '$2', $matches[0][$i]);
                $this->fileContent = str_replace ($matches[0], "", $this->fileContent);
                $className = "\\model" . "\\" . $funcName . "\\" . ucfirst ($funcName);
                $class = new $className;
                call_user_func_array ([$class, $funcName], [$this->url['vars']]);
            }
        }
    }

    protected function parseFunction ()
    {
        $isMatched = preg_match_all ('/{{function=.*?}}/', trim ($this->fileContent), $matches);
        $matched = $matches[0];
        foreach ($matched as $v) {
            $this->fileContent = str_replace ($v,"",$this->fileContent);
            $valid = preg_replace ('/{{function=(.*?)}}/', '$1', $v);
            $origin = "{{".$valid."}}";
            $data = explode ("||",$valid);
            $info = explode ("\\",$data[0]);
            $func = array_pop ($info);
            $class = !empty($info) ? implode ("\\",$info) : "";
            $args = [];

            $result = "";
            $argsInfo = array_slice ($data,1);
            foreach ($argsInfo as $value) {
                $argName = explode ("=",$value);
                if (method_exists ($this,$argName[0])) {
                    $this->callFunction ($argsInfo);

                }
                else {
                    $args[$argName[0]] = $argName[1];
                }
            }
            if (!empty($class)) {
                if (method_exists (new $class,$func)) $result = call_user_func_array ([new $class,$func],$args);
            }
            else{
                if(function_exists ($func)) $result = call_user_func_array ($func, $args);
            }
            if(!empty($this->outputOpinion) && $this->saveResult) $this->data[$this->outputOpinion] = $result;
            if($this->output) echo $result;
        }
    }

    protected function parseIf ()
    {
        $isMatched = preg_match ('/{{if\s.+?}}[\s\S].+[\s\S]+{{\/if}}/', $this->fileContent, $matches);
    }

    protected function parseVars ()
    {
        preg_match_all ('/{{\$.+?}}/', $this->fileContent, $matches);
        $matched = $matches[0];
        foreach ($matched as $v) {
            $valid = preg_replace ('/{{\$(.+?)}}/', '$1', $v);
            $origin = "{{\$".$valid."}}";
            $data = explode ("||",$valid);
            $args = array_slice ($data,1);
            $v = $data[0];
            preg_match_all ('/\[.+?\]/', $v, $matches);
            $matches = $matches[0];
            if(count($matches) > 0) {
                foreach ($matches as $value) {
                    $this->subscript = preg_replace ('/\[(.+?)\]/', '$1', $value);
                    $v = str_replace ($value,"",$v);
                }
            }
            if (strstr ($v, "%")) {
                $this->replaceText = substr ($v, "1");
                $this->replaceText = constant (strtoupper ($this->replaceText));
            } else {
                if (isset($this->data[$v])) {
                    $this->replaceText = $this->data[$v];
                } else {
                    eval("global \$$v;");
                    eval("\$this->replaceText = \"\$$v\";");
                }
            }
            if (count($args) > 0) {
                $this->callFunction ($args);
            }
            if($this->subscript != "") $this->replaceText = $this->replaceText[$this->subscript];
            $this->fileContent = str_replace ($origin, $this->replaceText, $this->fileContent);
        }
    }

    protected function callFunction($args)
    {
        foreach ($args as $key => $value) {
            $detail = explode ("=",$value);
            is_array ($detail[1]) ? $arg = $detail[1] : $arg = [$detail[1]];
            if($detail[0] == "output") call_user_func_array ([$this,$detail[0]], $arg);
            else if (method_exists ($this,$detail[0])) call_user_func_array ([$this,$detail[0]], $arg);
        }
    }

    protected function default($value)
    {
        if (empty($this->replaceText)) {
            $this->replaceText = $value;
        }
    }

    protected function output($output)
    {
        if($output == "true") $this->output = true;
        elseif($output == "false") $this->output = false;
        elseif($output == "both") $this->output = $this->saveResult = true;
        else {
            $this->saveResult = true;
            $this->outputOpinion = $output;
        }
    }
}