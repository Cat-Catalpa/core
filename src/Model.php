<?php

namespace startphp\Model;

class Model
{
    public function model ($modelClass)
    {
        if(is_bool (stripos ($modelClass,"\\"))){
            $modelClass = appClass ()."\\model"."\\".$modelClass;
        }
        return new $modelClass;
    }
}