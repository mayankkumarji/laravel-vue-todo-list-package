<?php

namespace Mayank\TodoTask;

use Illuminate\Support\Facades\Facade;

class TodoTaskFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'todotask';
    }
}