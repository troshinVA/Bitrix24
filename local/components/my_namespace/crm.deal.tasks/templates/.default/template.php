<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arParams
 * @var array $arResult
 * @global $APPLICATION
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog.php');
//require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');
$APPLICATION->SetTitle(Loc::getMessage('TITLE'));


?>
    <div>
        <? $APPLICATION->IncludeComponent('bitrix:main.ui.filter', '',
            [
                'FILTER_ID' => $arResult['FILTER_ID'],
                'GRID_ID' => $arResult['GRID_ID'],
                'FILTER' => $arResult['FILTER'],
                'ENABLE_LIVE_SEARCH' => true,
                'ENABLE_LABEL' => true
            ]);
        ?>
    </div>
    <div style="clear: both;"></div>
    <hr>
<?php
$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '',
    [
        'GRID_ID' => $arResult['GRID_ID'],
        'COLUMNS' => $arResult['COLUMNS'],
        'ROWS' => $arResult['ROWS'],
        'SHOW_ROW_CHECKBOXES' => false,
        'SORT' => $arResult['SORT'],
        'SORT_VARS' => $arResult['SORT_VARS'],
        'NAV_OBJECT' => $arResult['NAV_OBJECT'],
        'AJAX_MODE' => 'Y',
        'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
        'PAGE_SIZES' => [
            ['NAME' => '20', 'VALUE' => '20'],
            ['NAME' => '50', 'VALUE' => '50'],
            ['NAME' => '100', 'VALUE' => '100']
        ],
        'AJAX_OPTION_JUMP' => 'N',
        'SHOW_CHECK_ALL_CHECKBOXES' => false,
        'SHOW_ROW_ACTIONS_MENU' => true,
        'SHOW_GRID_SETTINGS_MENU' => true,
        'SHOW_NAVIGATION_PANEL' => true,
        'SHOW_PAGINATION' => true,
        'SHOW_SELECTED_COUNTER' => false,
        'SHOW_TOTAL_COUNTER' => false,
        'SHOW_PAGESIZE' => true,
        'SHOW_ACTION_PANEL' => true,
        'ALLOW_COLUMNS_SORT' => true,
        'ALLOW_COLUMNS_RESIZE' => true,
        'ALLOW_HORIZONTAL_SCROLL' => true,
        'ALLOW_SORT' => true,
        'ALLOW_PIN_HEADER' => true,
        'AJAX_OPTION_HISTORY' => 'N'
    ]
);
//require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/epilog_after.php');?>