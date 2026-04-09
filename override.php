<?php

use Bitrix\Main\DI\ServiceLocator;
use Otus\Crm\Service\Container as CustomCrmServiceContainer;

$crmServiceContainerClassName = CustomCrmServiceContainer::class;
ServiceLocator::getInstance()->addInstanceLazy('crm.service.container', [
    'className' => $crmServiceContainerClassName,
]);
