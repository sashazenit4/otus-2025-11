<?php

namespace Otus\Events;

use Bitrix\Main\UI\Extension;

class Main
{
    public static function beforePrologHandler()
    {
        Extension::load('otus.sliderHelper');
    }
}
