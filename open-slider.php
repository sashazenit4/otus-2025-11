<?php

use Bitrix\UI\Toolbar\Facade\Toolbar;
use Bitrix\UI\Buttons\Color;
use Bitrix\Main\UI\Extension;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle('Кнопка, открывающая страницу в слайдере');
$button = [
    'click' => 'openSlider',
    'text' => 'Открыть список книг в слайдере',
    'color' => Color::SUCCESS,
];
$button2 = [
    'link' => '/excel-export.php',
    'text' => 'Открыть список книг',
    'color' => Color::DANGER,
];

Toolbar::addButton($button);
Toolbar::addButton($button2);
Extension::load('ui.sidepanel');
?>
<script>
    function openSlider() {
        BX.SidePanel.Instance.open('/excel-export.php', {
            cacheable: false,
        });
    }
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
