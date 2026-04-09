<?php

namespace Otus\Rest;

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Rest\RestException;
use Bitrix\Main\Event;

use Bitrix\Main\Localization\Loc;
use Otus\Orm\BookTable;

Loc::loadMessages(__FILE__);

class Events
{
    /**
     * Register rest methods
     * Clear scope cache after register
     * \Bitrix\Main\Data\Cache::clearCache(true, '/rest/scope/');
     * @return array[]
     */
    public static function OnRestServiceBuildDescriptionHandler(): array
    {
        return [
            'otus.book' => [
                'otus.book.add' => [__CLASS__, 'add'],
                'otus.book.update' => [__CLASS__, 'update'],
                \CRestUtil::EVENTS => [
                    //код в списке событий
                    'onAfterOtusBookAdd' => [
                        'main', //модуль события
                        'onAfterOtusBookAdd', //название события
                        [__CLASS__, 'prepareEventData'] //обработчик
                    ],
                    //код в списке событий
                    'onBeforeOtusBookAdd' => [
                        'main', //модуль события
                        'onBeforeOtusBookAdd', //название события
                    ],
                ],
            ],
            'otus' => [
                'otus.newTest' => [__CLASS__, 'newTest'],
            ],
        ];
    }

    /**
     * Add element
     * @param $arParams - request params
     * @param $navStart - default start parameter (start from POST-data)
     * @param \CRestServer $server - server data
     * @return mixed
     * @throws RestException
     */
    public static function add($arParams, $navStart, \CRestServer $server)
    {
        //        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'PARAMS: '.var_export($arParams, true).PHP_EOL, FILE_APPEND);
        //        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'NAV: '.var_export($navStart, true).PHP_EOL, FILE_APPEND);
        //        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logRest.txt', 'SERVER: '.var_export($server, true).PHP_EOL, FILE_APPEND);

        $eventBefore = new Event('main', 'onBeforeOtusBookAdd', $arParams);
        $eventBefore->send();
        $originDataStoreResult = BookTable::add($arParams['BOOK']);
        if ($originDataStoreResult->isSuccess()) {
            $id = $originDataStoreResult->getId();
            $arParams['ID'] = $id;
            $event = new Event('main', 'onAfterOtusBookAdd', $arParams);
            $event->send();

            return $id;
        } else {
            throw new RestException(
                json_encode($originDataStoreResult->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }

    /**
     * Обновлят информацию о книге по её ИД
     * @param $arParams
     * @param $navStart
     * @param \CRestServer $server
     * @return void
     */
    public static function update($arParams, $navStart, \CRestServer $server)
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $isPost = $request->isPost();
        if (!$isPost) {
            throw new RestException(
                'Invalid HTTP METHOD. Use POST',
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
        $bookId = $arParams['book_id'];
        $fieldsToUpdate = $request->getPost('fields');
        $updateResult = BookTable::update($bookId, $fieldsToUpdate);
        if ($updateResult->isSuccess()) {
            return $bookId;
        } else {
            throw new RestException(
                json_encode($updateResult->getErrorMessages(), JSON_UNESCAPED_UNICODE),
                RestException::ERROR_ARGUMENT,
                \CRestServer::STATUS_OK
            );
        }
    }

    public static function newTest($arParams, $navStart, \CRestServer $server)
    {
        $request = Context::getCurrent()->getRequest();

        return [
            'arParams' => $arParams,
            'onlyQuery' => $request->getQueryList(),
            'onlyBody' => $request->getPostList()->toArray(),
            'navStart' => $navStart,
            'server' => [
                'methodName' => $server->getMethod(),
                'authData' => $server->getAuthData(),
            ],

            'httpMethod' => $request->isPost() ? 'POST' : 'GET',
        ];
    }

    /**
     * Prepare data
     * @param $arguments - data
     * @param $handler - handler
     * @return mixed
     */
    public static function prepareEventData($arguments, $handler)
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logRestEvent.txt', 'A: ' . var_export($arguments, true) . PHP_EOL, FILE_APPEND);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logRestEvent.txt', 'H: ' . var_export($handler, true) . PHP_EOL, FILE_APPEND);

        /** @var Event $event */
        $event = reset($arguments);
        $response = $event->getParameters();

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/logRestEvent.txt', 'R: ' . var_export($response, true) . PHP_EOL, FILE_APPEND);

        return $response;
    }
}
