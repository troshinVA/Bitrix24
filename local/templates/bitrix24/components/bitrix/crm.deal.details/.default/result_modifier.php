<?php

/**
 * @var array $arResult
 * @var array $unwantedFields
 * @var array $failedStages
 * @var int $cnt
 */
$unwantedFields = ['ID', 'STAGE_ID'];
$failedStages = ['LOSE', 'APOLOGY'];
$cnt = 0;
foreach ($arResult['ENTITY_FIELDS'] as $field) {
    if (in_array($field['name'], $unwantedFields)) {
        unset($arResult['ENTITY_FIELDS'][$cnt]);
    }

    if ($field['name'] == 'UF_CRM_FAIL_COMMENT' &&
        !in_array($arResult['ENTITY_DATA']['STAGE_ID'], $failedStages)) {
        unset($arResult['ENTITY_FIELDS'][$cnt]);
    }
    $cnt++;
}
