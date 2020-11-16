<?php

use Bitrix\Crm\PhaseSemantics;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arResult
 * @var array $unwantedFields
 * @global $APPLICATION
 */
$unwantedFields = ['ID', 'STAGE_ID'];

foreach ($arResult['ENTITY_FIELDS'] as $key => $field) {
    if (in_array($field['name'], $unwantedFields)) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }

    if ($field['name'] == 'UF_CRM_FAIL_COMMENT' &&
        CCrmDeal::GetSemanticID($arResult['ENTITY_DATA']['STAGE_ID'],
            CCrmDeal::GetCategoryID($arResult['ENTITY_ID'])) !== PhaseSemantics::FAILURE) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }
}

$arResult['TABS'][] = array(
    'id' => 'tab_tasks',
    'name' => Loc::getMessage('TASKS'),
    'loader' => array(
        'serviceUrl' => '/local/components/my_namespace/crm.deal.tasks/lazyload.ajax.php?&site' . SITE_ID . '&' . bitrix_sessid_get(),
        'componentData' => array(
            'template' => '',
            'params' => array(
                'INTERNAL_FILTER' => array('ASSOCIATED_DEAL_ID' => $arResult['ENTITY_DATA']['ID']),
            )
        )
    )
);
