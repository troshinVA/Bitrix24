<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Localization\Loc;
/** @global CMain $APPLICATION */
$APPLICATION->SetTitle(Loc::getMessage('SEC_TITLE'));
$APPLICATION->IncludeComponent(
    "my_namespace:crm.deal.tasks",
    "",
    array()
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

