<?php

namespace Awcodes\Documental\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Awcodes\Documental\Documental
 */
class Documental extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Awcodes\Documental\Documental::class;
    }
}
