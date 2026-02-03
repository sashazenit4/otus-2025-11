<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

return [
    'controllers' => [
        'value' => [
            'defaultNamespace' => '\\Aholin\\Crmcustomtab\\Controllers',
            'namespaces' => [
                '\\Aholin\\Crmcustomtab\\Controllers' => 'book', // можно указать свой неймспейс без указания имени класса
            ],
        ],
    ],
];
