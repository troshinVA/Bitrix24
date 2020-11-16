<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arParams
 * @var array $arResult
 * @global $APPLICATION
 */
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle(Loc::getMessage('TITLE'));

?>
<h2>Фильтр</h2>
<div>
    <? $APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
        'FILTER_ID' => $arResult['GRID_ID'],
        'GRID_ID' => $arResult['GRID_ID'],
        'FILTER' => $arResult['FILTER'],
        'ENABLE_LIVE_SEARCH' => true,
        'ENABLE_LABEL' => true
    ]); ?>
</div>
<div style="clear: both;"></div>
<hr>

<?php
//----------------------------------------------------------------------------------------------------------------->>>
$filterOption = new Bitrix\Main\UI\Filter\Options($arResult['GRID_ID']);
$filterData = $filterOption->getFilter($arResult['FILTER']);
$searchString = $filterOption->getSearchString();
$filter = [];
foreach ($filterData as $k => $v) {
    if ($k == 'DEAL_LIST') {
        if ($filterData[$k] !== '0') {
            $filter['UF_CRM_TASK'] = 'D_' . $filterData[$k];
        } else {
            unset($filter['UF_CRM_TASK']);
        }
    } else {
        $filter[$k] = $filterData[$k];
    }
}
$aSelect = [
    'TITLE',
    'DESCRIPTION',
    'RESPONSIBLE_NAME',
    'RESPONSIBLE_LAST_NAME',
    'DEADLINE',
    'UF_CRM_TASK',
    'CREATED_BY_NAME',
    'CREATED_BY_LAST_NAME'
];
$res = CTasks::GetList(
    $arResult['SORT'],
    $filter,
    $aSelect
);

while ($row = $res->GetNext()) {
    $list[] = [
        'data' => [
            'TITLE' => $row['TITLE'],
            'DESCRIPTION' => $row['DESCRIPTION'],
            'RESPONSIBLE_NAME' => $row['RESPONSIBLE_NAME'] . ' ' . $row['RESPONSIBLE_LAST_NAME'],
            'DEADLINE' => $row['DEADLINE'],
            'CREATOR' => $row['CREATED_BY_NAME'] . ' ' . $row['CREATED_BY_LAST_NAME'],
            'DEAL_ID' => $row['UF_CRM_TASK'][0]
        ]
    ];
}

//<<<<----------------------------------------------------------------------------------------------------------------
$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => $arResult['GRID_ID'],
    'COLUMNS' => $arResult['COLUMNS'],
    'ROWS' => $list,
    'SHOW_ROW_CHECKBOXES' => false,
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
]);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>