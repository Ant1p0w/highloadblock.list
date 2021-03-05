<?

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @property  arParams
 * @property  arResult
 */
class HighloadBlockList extends \CBitrixComponent
{
    protected $arrFilter = [];

    public function onPrepareComponentParams($arParams): array
    {
        if (!isset($arParams["CACHE_TIME"])) {
            $arParams["CACHE_TIME"] = 86000;
        }

        $arParams["HIGHLOADBLOCK_ID"] = trim($arParams["HIGHLOADBLOCK_ID"]);

        if (!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER"])) {
            $arParams["SORT_ORDER"] = "DESC";
        }

        if (!is_array($arParams["FIELD_CODE"])) {
            $arParams["FIELD_CODE"] = [];
        }

        foreach ($arParams["FIELD_CODE"] as $key => $val) {
            if (!$val) {
                unset($arParams["FIELD_CODE"][$key]);
            }
        }

        if (!is_numeric($arParams["ELEMENT_COUNT"]) || !$arParams["ELEMENT_COUNT"] > 0) {
            $arParams["ELEMENT_COUNT"] = 10;
        }

        if (!empty($arParams["FILTER_NAME"]) && preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"])) {
            $arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
            if (is_array($arrFilter)) {
                $this->arrFilter = $arrFilter;
            }
        }

        return $arParams;
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('highloadblock')) {
            throw new SystemException('Модуль highloadblock не установлен.');
        }
    }

    protected function getResult()
    {
        $hlblock = HL\HighloadBlockTable::getById($this->arParams['HIGHLOADBLOCK_ID'])->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList([
            "select" => $this->arParams['FIELD_CODE'],
            "order"  => [$this->arParams['SORT_BY'] => $this->arParams['SORT_ORDER']],
            "filter" => $this->arrFilter,
            "cache"  => [
                "ttl"         => $this->arParams['CACHE_TIME'],
                "cache_joins" => true
            ],
        ]);

        $this->arResult = $rsData->fetchAll();
    }

    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getResult();
            $this->includeComponentTemplate();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}
