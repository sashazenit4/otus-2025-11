<?php

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\UserTable;
use Otus\Entities\Main\UserRepository;

$serviceLocator = ServiceLocator::getInstance();

// регистрация сервис локатором сервиса user.repository
// $serviceLocator->addInstance('user.repository', new UserRepository(UserTable::class));
$serviceLocator->addInstanceLazy('user.repository', [
    'constructor' => static function () {
        return new UserRepository(UserTable::class);
    }
]);
