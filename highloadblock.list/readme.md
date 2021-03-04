# Список элементов и highload-блока на D7

Пример вызова:

~~~
global $arDateFilter;
$arDateFilter = ['>UF_DATE' => '01.01.2021'];

$APPLICATION->IncludeComponent(
    "antipow:highloadblock.list",
    "",
    [
        "CACHE_TIME"       => "86000",
        "CACHE_TYPE"       => "A",
        "FIELD_CODE"       => ["ID", "UF_NAME", "UF_XML_ID", "UF_DATE"],
        "HIGHLOADBLOCK_ID" => 1,
        "SORT_BY"          => "ID",
        "SORT_ORDER"       => "ASC",
        "ELEMENT_COUNT"    => 10,
        "FILTER_NAME"      => "arDateFilter"
    ]
);
~~~
