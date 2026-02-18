<?php

use Bitrix\Main\UI\Extension;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Использование расширений');

Extension::load('aholincrmcustomtab.tools.popup');
?>
<script>
    let popup = BX.Aholincrmcustomtab.Tools.Popup.init({
        content: 'TEST CONTENT',
        darkMode: true,
    });

    popup.createAndShow();

    setTimeout(() => {
        popup.destroy();
    }, 2500);
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
