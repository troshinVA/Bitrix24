<?php
use Bitrix\Crm\PhaseSemantics;
/**
 * @var array $arResult
 * @var array $unwantedFields
 */
$unwantedFields = ['ID', 'STAGE_ID'];

foreach ($arResult['ENTITY_FIELDS'] as $key => $field) {
    if (in_array($field['name'], $unwantedFields)) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }

    if ($field['name'] == 'UF_CRM_FAIL_COMMENT' &&
        CCrmDeal::GetSemanticID($arResult['ENTITY_DATA']['STAGE_ID']) !== PhaseSemantics::FAILURE) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }
}
