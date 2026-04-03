<?php

namespace Otus\Crm\Lead;

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

define('BX_CRONTAB', true);
class Agents
{
    public static function cleanOldLeads(int $days): string
    {
        Loader::includeModule('crm');
        $dealFactory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
        $deals = $dealFactory->getItems([
            'filter' => [
                '<DATE_CREATE' => ((new DateTime)->add(sprintf('-%d days', $days)))->format('d.m.Y H:I:s'),
                'STAGE_ID' => 'NEW',
            ],
            'select' => ['ID'],
        ]);

        foreach ($deals as $deal) {
            $deleteOperation = $dealFactory->getDeleteOperation($deal);
            $deleteOperation->disableAllChecks();
            $deleteOperation->launch();
        }

        return sprintf('\Otus\Crm\Lead\Agents::cleanOldLeads(%d);', $days);
    }
}
