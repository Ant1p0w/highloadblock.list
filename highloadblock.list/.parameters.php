<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//Сортировка
$arSorts = ["ASC" => "По возрастанию", "DESC" => "По убыванию"];
$arSortFields = [
    "ID"      => "ID",
    "UF_NAME" => "Название",
    "UF_SORT" => "Сортировка"
];

//Параметры
$arComponentParameters = [
    "GROUPS"     => [
    ],
    "PARAMETERS" => [
        "HIGHLOADBLOCK_ID" => [
            "PARENT"  => "BASE",
            "NAME"    => "ID инфоблока",
            "TYPE"    => "STRING",
            "DEFAULT" => '',
        ],
        "SORT_BY"          => [
            "PARENT"            => "DATA_SOURCE",
            "NAME"              => "Поле сортировки",
            "TYPE"              => "LIST",
            "DEFAULT"           => "ID",
            "VALUES"            => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ],
        "SORT_ORDER"       => [
            "PARENT"            => "DATA_SOURCE",
            "NAME"              => "Направление сортировки",
            "TYPE"              => "LIST",
            "DEFAULT"           => "ASC",
            "VALUES"            => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ],
        "FIELD_CODE"       => [
            "PARENT"  => "BASE",
            "NAME"    => "Поля для вывода",
            "TYPE"    => "LIST",
            "DEFAULT" => ['ID', 'UF_NAME'],
        ],
        "ELEMENT_COUNT"    => [
            "PARENT"  => "BASE",
            "NAME"    => "Кол-во элементов",
            "TYPE"    => "STRING",
            "DEFAULT" => "10",
        ],
        "FILTER_NAME"      => [
            "PARENT"  => "BASE",
            "NAME"    => "Имя фильтра",
            "TYPE"    => "STRING",
            "DEFAULT" => "",
        ],
        "CACHE_TIME"       => ["DEFAULT" => 86000],
    ],
];
