<?php

use Bitrix\Main\DI\ServiceLocator;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы Service Locator (использование сервиса)');

try {
    $email = 'holinshura@gmail.com';
    $serviceLocator = ServiceLocator::getInstance();
    $userController = $serviceLocator->get('importantUserController');

    //     пример регистрации в .settings.php
    //     'services' => array(
    //     'value' => array(
    //       'user.controller' => array(
    //         'constructor' => static function () {
    //           return new UserController(new UserRepository(UserTable::class));
    //         },
    //       ),
    //     ),
    //   ),
    $userRepository = $serviceLocator->get('user.repository');
    echo $userController->handle($email) . '<br>';
    echo $userRepository->findByEmail($email);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
