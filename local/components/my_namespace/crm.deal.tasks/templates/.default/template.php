<?php


use Bitrix\Main\Grid\Panel\Actions;
use Bitrix\Main\Grid\Panel\Snippet\Onchange;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arParams
 * @var array $arResult
 * @global $APPLICATION
 */

$grid_options = new Bitrix\Main\Grid\Options('task_list');
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams();

$nav = new Bitrix\Main\UI\PageNavigation('task_list');
$nav->allowAllRecords(true)
    ->setPageSize($nav_params['nPageSize'])
    ->initFromUri();

// Кнопка удалить
$onchange = new Onchange();
$onchange->addAction(
    [
        'ACTION' => Actions::CALLBACK,
        'CONFIRM' => true,
        'CONFIRM_APPLY_BUTTON'  => 'Подтвердить',
        'DATA' => [
            ['JS' => 'Grid.removeSelected()']
        ]
    ]
);

$list = [
    [
        'data'    => [ //Данные ячеек
            "ID" => 1,
            "NAME" => "Название 1",
            "AMOUNT" => 1000,
            "PAYER_NAME" => "Плательщик 1"
        ],
        'actions' => [ //Действия над ними
            [
                'text'    => 'Редактировать',
                'onclick' => 'document.location.href="/accountant/reports/1/edit/"'
            ],
            [
                'text'    => 'Удалить',
                'onclick' => 'document.location.href="/accountant/reports/1/delete/"'
            ]

        ],
    ], [
        'data'    => [ //Данные ячеек
            "ID" => 2,
            "NAME" => "Название 2",
            "AMOUNT" => 3000,
            "PAYER_NAME" => "Плательщик 2"
        ],
        'actions' => [ //Действия над ними
            [
                'text'    => 'Редактировать',
                'onclick' => 'document.location.href="/accountant/reports/2/edit/"'
            ],
            [
                'text'    => 'Удалить',
                'onclick' => 'document.location.href="/accountant/reports/2/delete/"'
            ]

        ],
    ]
];



$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => 'report_list',
    'COLUMNS' => [
        ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true],
        ['id' => 'DATE', 'name' => 'Дата', 'sort' => 'DATE', 'default' => true],
        ['id' => 'AMOUNT', 'name' => 'Сумма', 'sort' => 'AMOUNT', 'default' => true],
        ['id' => 'PAYER_INN', 'name' => 'ИНН Плательщика', 'sort' => 'PAYER_INN', 'default' => true],
        ['id' => 'PAYER_NAME', 'name' => 'Плательщик', 'sort' => 'PAYER_NAME', 'default' => true],
        ['id' => 'IS_SPEND', 'name' => 'Тип операции', 'sort' => 'IS_SPEND', 'default' => true],
    ],
    'ROWS' => $list,
    'SHOW_ROW_CHECKBOXES' => true,
    'NAV_OBJECT' => $nav,
    'AJAX_MODE' => 'Y',
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'PAGE_SIZES' => [
        ['NAME' => "5", 'VALUE' => '5'],
        ['NAME' => '10', 'VALUE' => '10'],
        ['NAME' => '20', 'VALUE' => '20'],
        ['NAME' => '50', 'VALUE' => '50'],
        ['NAME' => '100', 'VALUE' => '100']
    ],
    'AJAX_OPTION_JUMP'          => 'N',
    'SHOW_CHECK_ALL_CHECKBOXES' => true,
    'SHOW_ROW_ACTIONS_MENU'     => true,
    'SHOW_GRID_SETTINGS_MENU'   => true,
    'SHOW_NAVIGATION_PANEL'     => true,
    'SHOW_PAGINATION'           => true,
    'SHOW_SELECTED_COUNTER'     => true,
    'SHOW_TOTAL_COUNTER'        => true,
    'SHOW_PAGESIZE'             => true,
    'SHOW_ACTION_PANEL'         => true,
    'ACTION_PANEL'              => [
        'GROUPS' => [
            'TYPE' => [
                'ITEMS' => [
                    [
                        'ID'    => 'set-type',
                        'TYPE'  => 'DROPDOWN',
                        'ITEMS' => [
                            ['VALUE' => '', 'NAME' => '- Выбрать -'],
                            ['VALUE' => 'plus', 'NAME' => 'Поступление'],
                            ['VALUE' => 'minus', 'NAME' => 'Списание']
                        ]
                    ],
                    [
                        'ID'       => 'edit',
                        'TYPE'     => 'BUTTON',
                        'TEXT'        => 'Редактировать',
                        'CLASS'        => 'icon edit',
                        'ONCHANGE' => ''
                    ],
                    [
                        'ID'       => 'delete',
                        'TYPE'     => 'BUTTON',
                        'TEXT'     => 'Удалить',
                        'CLASS'    => 'icon remove',
                        'ONCHANGE' => $onchange->toArray()
                    ],
                ],
            ]
        ],
    ],
    'ALLOW_COLUMNS_SORT'        => true,
    'ALLOW_COLUMNS_RESIZE'      => true,
    'ALLOW_HORIZONTAL_SCROLL'   => true,
    'ALLOW_SORT'                => true,
    'ALLOW_PIN_HEADER'          => true,
    'AJAX_OPTION_HISTORY'       => 'N'
]);

var_dump($arResult);