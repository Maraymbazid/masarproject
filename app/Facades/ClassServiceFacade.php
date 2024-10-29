<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ClassServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'classservice';
    }
}
