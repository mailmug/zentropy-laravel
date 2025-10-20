<?php

namespace MailMug\ZentropyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Zentropy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zentropy-laravel'; // matches service container binding
    }
}
