<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule("iblock");

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'questions'),
	true);
$ar_res = $res->Fetch();
$question_id = $ar_res['ID'];

$arSelect = Array("ID", "property_incques");
$arFilter = Array("!property_endques_value" => "Y", "IBLOCK_ID" => $question_id);
$arSort = Array("property_dateques" => 'DESC');
$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

$val = Array();
while ($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $val[$arFields["ID"]] = "[".$arFields["ID"]."] ".$arFields["PROPERTY_INCQUES_VALUE"];
}

$arComponentParameters = array(
    "GROUPS" => array(
	"BASE" => array(
	    "NAME" => GetMessage("STANDARD_SETTINGS")
	)
    ),
    "PARAMETERS" => array(
	"IBLOCK_QUESTION" => array(
	    "PARENT" => "BASE",
	    "NAME" => GetMessage("SELECT_A_QUESTION"),
	    "TYPE" => "LIST",
	    "VALUES" => $val,
	    "REFRESH" => "Y"
	)
    )
);

?>
