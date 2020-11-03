<?php

/**
 * @var array $arResult
 * @var array $unwantedFields
 * @var array $failedStages
 */
$unwantedFields = ['ID', 'STAGE_ID'];
$failedStages = ['LOSE', 'APOLOGY'];

foreach ($arResult['ENTITY_FIELDS'] as $key => $field) {

    if (in_array($field['name'], $unwantedFields)) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }

    if ($field['name'] == 'UF_CRM_FAIL_COMMENT' &&
        !in_array($arResult['ENTITY_DATA']['STAGE_ID'], $failedStages)) {
        unset($arResult['ENTITY_FIELDS'][$key]);
    }
}

