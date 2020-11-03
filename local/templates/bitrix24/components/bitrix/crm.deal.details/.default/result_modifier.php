<?php

/**
 * @var array $arResult
 */
// remove unwanted fields
unset($arResult['ENTITY_FIELDS'][0]);
if ($arResult['ENTITY_DATA']['STAGE_ID'] !== 'LOSE' && $arResult['ENTITY_DATA']['STAGE_ID'] !== 'APOLOGY')
{
    unset($arResult['ENTITY_FIELDS'][21]);
}
unset($arResult['ENTITY_FIELDS'][7]);
