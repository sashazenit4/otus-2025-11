<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;

class aholin_crmcustomtab extends \CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'aholin.crmcustomtab';
        $this->MODULE_NAME = 'Таб с книгами в сделке';
        $this->MODULE_DESCRIPTION = 'Модуль, выводящий список книг, обязательных для прочтения сотрудниками компании в каждоый сделке';
        $this->MODULE_VERSION = '1.0.1';
        $this->MODULE_VERSION_DATE = '2026-02-06';
        $this->PARTNER_NAME = 'Otus';
        $this->PARTNER_URI = 'https://otus.ru';
    }

    public function DoInstall()
    {
        $this->InstallEvents();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUnInstall()
    {
        $this->UnInstallEvents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallEvents(): void
    {
        $eventManager = EventManager::getInstance();

        $eventManager->registerEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Aholin\\Crmcustomtab\\Crm\\Handlers',
            'updateTabs'
        );
    }

    public function UnInstallEvents(): void
    {
        $eventManager = EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Aholin\\Crmcustomtab\\Crm\\Handlers',
            'updateTabs'
        );
    }
}
