<?php

use Otus\DI\Container;
use Otus\Entities\Main\UserController;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Демо работы DI контейнера');

try {
    $email = 'holinshura@gmail.com';
    // $userOrmClass = UserTable::class;
    // $userRepository = new UserRepository($userOrmClass);
    // $userController = new UserController($userRepository);
    // echo $userController->handle($email);

    echo ((new Container())->get(UserController::class))->handle($email);
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
