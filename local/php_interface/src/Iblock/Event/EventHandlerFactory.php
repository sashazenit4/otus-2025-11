<?php

namespace Otus\Iblock\Event;

use Otus\Helper\Iblock as IblockHelper;
use Otus\Constant\Iblock as IblockConstant;

class EventHandlerFactory
{
    public static function create(int $iblockId)
    {
        $handlers = [
            IblockConstant::CLIENTS_IBLOCK_CODE => ClientsEventAddHandler::class,
        ];

        $iblockCode = IblockHelper::getIblockCodeById($iblockId);

        $handlerClass = $handlers[$iblockCode];
        if (!isset($handlers[$iblockCode])) {
            error_log("Обработчик событий для IBLOCK_ID {$iblockId} не найден");
            return null;
        }

        return new $handlerClass();
    }
}
