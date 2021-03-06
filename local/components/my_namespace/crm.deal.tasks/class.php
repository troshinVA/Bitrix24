<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;

class CDealTasks extends CBitrixComponent
{
    /**
     * @throws LoaderException
     */
    private function init()
    {
        $this->arResult['FILTER_ID'] = 'DEAL_TASKS';
        $this->arResult['GRID_ID'] = 'DEAL_TASKS';
        \Bitrix\Main\Loader::includeModule('tasks');
        \Bitrix\Main\Loader::includeModule('crm');
    }

    /**
     * @param $gridOptions
     * @return array
     */
    private function getDataFilter($gridOptions)
    {
        $filterOptions = new Bitrix\Main\UI\Filter\Options($this->arResult['FILTER_ID']);
        $filter = $gridOptions->GetFilter($this->arResult['FILTER']);
        $filterData = $filterOptions->getFilter($this->arResult["FILTER"]);
        $searchString = $filterOptions->getSearchString();
        foreach ($filterData as $k => $v) {
            if($k == 'DEAL_LIST'){
                if($v == '0'){
                    unset($filter['UF_CRM_TASK']);
                }else{
                    $filter['UF_CRM_TASK'] = 'D_'.$v;
                }
            }else{
                $filter[$k] = $v;
            }
        }

        if(isset($this->arParams['INTERNAL_FILTER']['ASSOCIATED_DEAL_ID'])){
            $filter['UF_CRM_TASK'] = 'D_' . $this->arParams['INTERNAL_FILTER']['ASSOCIATED_DEAL_ID'];
        }

        return $filter;
    }

    /**
     * @return mixed
     * @global $USER
     */
    private function makeDealList()
    {
        global $USER;
        $dealsList = CCrmDeal::GetList(
            $arOrder = array('ID' => 'ASC'),
            $arFilter = array('=ASSIGNED_BY' => $USER->GetID()),
            array('ID', 'TITLE', 'COMPANY_TITLE'),
            false
        );
        while ($deal = $dealsList->fetch()) {
            $deals[$deal['ID']] = $deal['ID'] . ' - ' . $deal['TITLE'] . ' - ' . $deal['COMPANY_TITLE'];
        }
        return ($deals);
    }

    private function setUiFilter()
    {
        $items = ['0' => Loc::getMessage('ALL_DEAL')];
        $items = array_merge($items, $this->makeDealList());
        $this->arResult['FILTER'] = array(
            array("id" => "TITLE", "name" => Loc::getMessage('TASK_TITLE'), "default" => false),
            array("id" => "RESPONSIBLE_NAME", "name" => Loc::getMessage('RESPONSIBLE'), "default" => false),
            array("id" => "DEADLINE", "name" => Loc::getMessage('DEADLINE'), "type" => "date", "default" => false),
            array("id" => "DEAL_LIST", "name" => Loc::getMessage('CHOOSE_DEAL'), "default" => false, "type" => "list",
                "items" => $items)
        );
    }

    private function setColumns()
    {
        $this->arResult['COLUMNS'] = array(
            array("id" => "TITLE", "name" => Loc::getMessage('TASK_TITLE'), "sort" => "TITLE", "default" => true, "editable" => false),
            array("id" => "DESCRIPTION", "name" => Loc::getMessage('DESCRIPTION'), "sort" => "DESCRIPTION", "default" => true, "editable" => false),
            array("id" => "RESPONSIBLE_NAME", "name" => Loc::getMessage('RESPONSIBLE'), "sort" => "RESPONSIBLE_NAME", "default" => true, "editable" => false),
            array("id" => "DEADLINE", "name" => Loc::getMessage('DEADLINE'), "sort" => "DEADLINE", "default" => true, "editable" => false),
            array("id" => "CREATOR", "name" => Loc::getMessage('CREATOR'), "sort" => "CREATOR", "default" => true, "editable" => false),
            array("id" => "DEAL_ID", "name" => Loc::getMessage('ASSOCIATED_DEAL_ID'), "sort" => "DEAL_ID", "default" => true, "editable" => false)
        );
    }

    /**
     * @throws TasksException
     */
    public function setRows()
    {
        $gridOptions = new CGridOptions($this->arResult['GRID_ID']);
        $navParams = $gridOptions->GetNavParams();
        $nav = new PageNavigation($this->arResult['GRID_ID']);
        $nav->allowAllRecords(true)
            ->setPageSize($navParams['nPageSize'])
            ->initFromUri();
        if ($nav->allRecordsShown()) {
            $navParams = false;
        } else {
            $navParams['iNumPage'] = $nav->getCurrentPage();
        }
        $sort = $gridOptions->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
        $aSelect = [
            'TITLE',
            'DESCRIPTION',
            'RESPONSIBLE_NAME',
            'RESPONSIBLE_LAST_NAME',
            'DEADLINE',
            'UF_CRM_TASK',
            'CREATED_BY_NAME',
            'CREATED_BY_LAST_NAME'
        ];
        $res = $this->getTasks($sort['sort'], $this->getDataFilter($gridOptions), $aSelect);

        while ($row = $res->GetNext()) {
            $list[] = [
                'data' => [
                    'TITLE' => $row['TITLE'],
                    'DESCRIPTION' => $row['DESCRIPTION'],
                    'RESPONSIBLE_NAME' => $row['RESPONSIBLE_NAME'] . ' ' . $row['RESPONSIBLE_LAST_NAME'],
                    'DEADLINE' => $row['DEADLINE'],
                    'CREATOR' => $row['CREATED_BY_NAME'] . ' ' . $row['CREATED_BY_LAST_NAME'],
                    'DEAL_ID' => $row['UF_CRM_TASK'][0]
                ]
            ];

            $this->arResult['NAV-OBJECT'] = $nav;
            $this->arResult['SORT'] = $sort['sort'];
            $this->arResult['SORT_VARS'] = $sort['vars'];
            $this->arResult['ROWS'] = $list;
        }
    }

    /**
     * @param $aSort
     * @param $aFilter
     * @param $aSelect
     * @return bool|CDBResult
     * @throws TasksException
     */
    private function getTasks($aSort, $aFilter, $aSelect)
    {
        if (CModule::IncludeModule("tasks")) {
            $taskList = CTasks::GetList(
                $aSort,
                $aFilter,
                $aSelect
            );
        } else {
            $taskList = 'error: Task module does not include';
        };
        return $taskList;
    }

    /**
     * @return array|mixed|null
     * @throws LoaderException
     * @throws TasksException
     */
    public function executeComponent()
    {
        $this->init();
        $this->setUiFilter();
        $this->setColumns();
        $this->setRows();
        $this->includeComponentTemplate();

        return $this->arResult;
    }

}
