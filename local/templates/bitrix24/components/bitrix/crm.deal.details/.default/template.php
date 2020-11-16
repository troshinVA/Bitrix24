<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Application;

$bitrixTemplate = $component->getPath().'/templates/'.$this->GetName().'/'.$this->GetPageName().'.php';
require_once(Application::getDocumentRoot().$bitrixTemplate);
