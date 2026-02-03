<?php

use Bitrix\Main\ModuleManager;

class aholin_crmcustomtab extends \CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'aholin.crmcustomtab';
        $this->MODULE_NAME = 'Таб с книгами в сделке';
        $this->MODULE_DESCRIPTION = 'Модуль, выводящий список книг, обязательных для прочтения сотрудниками компании в каждоый сделке';
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '03.02.2026';
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUnInstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
