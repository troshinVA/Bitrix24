<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

/*$APPLICATION->IncludeComponent(
	'bitrix:ui.sidepanel.wrapper',
	'',
	[
		'POPUP_COMPONENT_NAME' => 'bitrix:catalog.productcard.controller',
		'POPUP_COMPONENT_TEMPLATE_NAME' => '.default',
		'POPUP_COMPONENT_PARAMS' => [
			'SEF_MODE' => 'Y',
			'SEF_FOLDER' => '/shop/catalog/',
		],
		'USE_PADDING' => false,
		'USE_UI_TOOLBAR' => 'Y'
	]
); */
$APPLICATION->IncludeComponent(
	"bitrix:crm.catalog.controller",
	"",
	array(
		'SEF_MODE' => 'Y',
		'SEF_FOLDER' => '/crm/catalog/',
	)
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');