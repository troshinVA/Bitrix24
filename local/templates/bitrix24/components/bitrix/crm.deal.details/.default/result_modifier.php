<?php

/**
 * @var array $arResult
 */
// remove unwanted fields
unset($arResult['ENTITY_DATA']['ID']);
if ($arResult['ENTITY_DATA']['STAGE_ID'] !== 'LOSE' && $arResult['ENTITY_DATA']['STAGE_ID'] !== 'APOLOGY')
{
    unset($arResult['ENTITY_DATA']['UF_CRM_FAIL_COMMENT']);
}
//unset($arResult['ENTITY_DATA']['STAGE_ID']);
var_dump($arResult['ENTITY_DATA']);
var_dump($arResult['ENTITY_DATA']['ID']);


