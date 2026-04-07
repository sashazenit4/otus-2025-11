<?php

namespace Otus\Iblock\Event;

class ClientsEventAddHandler implements OnBeforeAddEventHandlerInterface, OnAfterAddEventHandlerInterface
{
    public function onBeforeAdd(&$element)
    {
        $element['NAME'] = 'OTUS - ' . $element['NAME'];
    }

    public function onAfterAdd(&$element)
    {
        \CIMNotify::Add([
            'MESSAGE' => sprintf(
                'Создана новая запись о [url=/services/lists/%s/element/0/%s/]клиенте - %s[/url]',
                $element['IBLOCK_ID'],
                $element['ID'],
                $element['NAME'],
            ),
            'TO_USER_ID' => 1,
        ]);
    }
}
