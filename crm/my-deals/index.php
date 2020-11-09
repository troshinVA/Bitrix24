<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global CMain $APPLICATION */
$APPLICATION->SetTitle("Мои сделки");
$APPLICATION->IncludeComponent(
    "my_namespace:crm.my-deals",
    "",
    array()
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
