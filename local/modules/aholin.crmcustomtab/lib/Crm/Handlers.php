<?php

namespace Aholin\Crmcustomtab\Crm;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Otus\Orm\BookTable;
use Bitrix\Main\Config\Option;

class Handlers
{
    public const MID = 'aholin.crmcustomtab';
    public static function updateTabs(Event $event): EventResult
    {
        $tabs = $event->getParameter('tabs');
        $isModuleActive = Option::get(self::MID, 'ACTIVE', 'N');
        $isModuleActive = $isModuleActive === 'Y';
        $availableEntityTypeIds = explode(
            ',',
            Option::get(self::MID, 'TAB_DISPLAY_CRM_ENTITY_TYPE_ID', '2'),
        );

        $entityTypeId = $event->getParameter('entityTypeID');

        if (
            $isModuleActive &&
            in_array($entityTypeId, $availableEntityTypeIds)
        ) {
            $tabs[] = [
                'id' => 'book_to_read',
                'name' => 'Рекомендуем почитать',
                'loader' => [
                    'serviceUrl' => sprintf(
                        '/local/components/otus/book.grid/lazyload.ajax.php?site=%s&%s',
                        SITE_ID,
                        \bitrix_sessid_get(),
                    ),
                    'componentData' => [
                        'params' => [
                            'BOOK_PREFIX' => 'Книги дня ' . (new \DateTime())->format('d.m.Y'),
                            'ORM_CLASS' => BookTable::class,
                        ],
                        'template' => '.default',
                    ],
                ],
            ];
        }

        return new EventResult(EventResult::SUCCESS, ['tabs' => $tabs]);
    }
}
