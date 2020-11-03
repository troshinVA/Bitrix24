<?php

/**
 * @var array $arResult
 * @var array $unwantedFields
 * @var int $cnt
 */
// remove unwanted fields
$unwantedFields = ['ID', 'STAGE_ID'];
$cnt = 0;
foreach ($arResult['ENTITY_FIELDS'] as $field) {
    if (in_array($field['name'], $unwantedFields)) {
        unset($arResult['ENTITY_FIELDS'][$cnt]);
    }

    if ($field['name'] == 'UF_CRM_FAIL_COMMENT' &&
        $arResult['ENTITY_DATA']['STAGE_ID'] !== 'LOSE' &&
        $arResult['ENTITY_DATA']['STAGE_ID'] !== 'APOLOGY') {
        unset($arResult['ENTITY_FIELDS'][$cnt]);
    }
    $cnt++;
}
