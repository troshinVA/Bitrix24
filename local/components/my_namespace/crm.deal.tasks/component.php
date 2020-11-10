<?php
use Bitrix\Main\Loader;
if (!Loader::IncludeModule('crm')) {
    ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED'));
    return;
}

$arResult = 'text';
$this->IncludeComponentTemplate();
