<?php

use Bitrix\Main\Loader;

/** @global $USER */
if (!Loader::IncludeModule('crm')) {
    ShowError(GetMessage('CRM_MODULE_NOT_INSTALLED'));
    return;
}

// Task 2
$dealsList = CCrmDeal::GetList(
    $arOrder = array('ID' => 'ASC'),
    $arFilter = array('=ASSIGNED_BY' => $USER->GetID()),
    array(),
    false
);
while ($deal = $dealsList->fetch()) {
    $deals[] = $deal;
}

// Task 2.1
$activitiesList = CCrmActivity::GetList(
    $arOrder = array('OWNER_ID' => 'ASC'),
    $arFilter = array('=OWNER_TYPE_ID' => '2','=RESPONSIBLE_ID' => $USER->GetID()),
    $arGroupBy = false,
    $arNavStartParams = false,
    $arSelectFields = array('OWNER_ID'),
    $arOptions = array()
);
while ($activity = $activitiesList->fetch()) {
    $ownerIds[] = $activity['OWNER_ID'];
}
$ownerIds = array_values(array_unique($ownerIds));

$dealsList = CCrmDeal::GetList(
    $arOrder = array('ID' => 'ASC'),
    $arFilter = array('=ASSIGNED_BY' => $USER->GetID(),'!ID' => $ownerIds),
    array(),
    false
);
while ($deal = $dealsList->fetch()) {
    $deals[] = $deal;
}

// Task 2.2
$activitiesList = CCrmActivity::GetList(
    $arOrder = array('OWNER_ID' => 'ASC'),
    $arFilter = array('=OWNER_TYPE_ID' => '2', '=RESPONSIBLE_ID' => $USER->GetID()),
    false,
    false,
    $arSelectFields = array('OWNER_ID', 'DEADLINE'),
    array()
);
while ($activity = $activitiesList->fetch()) {
    $dealsId[] = $activity['OWNER_ID'];
    if ($activity['DEADLINE'] < date('j.m.Y h:i:s')) {
        $expiredActivities[] = $activity['OWNER_ID'];
    }
}
$dealsId = array_values(array_unique($dealsId));
$expiredActivities = array_values(array_unique($expiredActivities));

$dealsList = CCrmDeal::GetList(
    $arOrder = array('ID' => 'ASC'),
    $arFilter = array('=ASSIGNED_BY' => $USER->GetID(),
        array(
            'LOGIC' => 'OR',
            array('!ID' => $dealsId),
            array('ID' => $expiredActivities)
        )
    ),
    array(),
    false
);
while ($deal = $dealsList->fetch()) {
    $deals[] = $deal;
}

//var_dump($deals);
$arResult = $deals;
$this->IncludeComponentTemplate();
