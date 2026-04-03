<?php

use Bitrix\Main\Diag\Debug;

function logDateTimeAgent(): string
{
    Debug::dumpToFile((new \DateTime)->format('d.m.Y H:i:s'));
    return 'logDateTimeAgent();';
}
