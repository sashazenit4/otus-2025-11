<?php

use Otus\Iblock\Event\IblockEventHandler;

$eventManager = \Bitrix\Main\EventManager::getInstance();

/**
 * Доступны OnBeforeAdd, OnAfterAdd, OnBeforeUpdate, OnAfterUpdate
 */

$eventManager->addEventHandler('', 'PantoneColorsOnBeforeAdd', [
    'HighloadEvents',
    'beforeAdd',
]);

class HighloadEvents
{
    public static function beforeAdd(\Bitrix\Main\Entity\Event $event): \Bitrix\Main\Entity\EventResult
    {
        $params = $event->getParameters();
        $params['fields']['UF_NAME'] = !isset($params['fields']['UF_COLOR_PANTONE_CODE'])
            ? $params['fields']['UF_NAME'] :
            'ЦВЕТ ПАНТОНА: ' . $params['fields']['UF_NAME'];

        $result = new \Bitrix\Main\Entity\EventResult(\Bitrix\Main\Entity\EventResult::SUCCESS);
        $result->modifyFields($params['fields']);
        $event->getEntity()->cleanCache();
        return $result;
    }
}

$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd', function (&$fields) {
    IblockEventHandler::onBeforeAddDispatch($fields);
    return $fields;
});

$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementAdd', function (&$fields) {
    IblockEventHandler::onAfterAddDispatch($fields);
    return $fields;
});

$eventManager->addEventHandlerCompatible('rest', 'OnRestServiceBuildDescription', ['Otus\Rest\Events', 'OnRestServiceBuildDescriptionHandler']);
$eventManager->addEventHandler('main', 'onAfterOtusBookAdd', function ($arParams) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logRestEvent.txt', 'PARAMS: ' . var_export($arParams, true) . PHP_EOL, FILE_APPEND);
});
