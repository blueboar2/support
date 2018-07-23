<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule("iblock");

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'questions'),
	true);
$ar_res = $res->Fetch();
$question_id = $ar_res['ID'];

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'answers'),
	true);
$ar_res = $res->Fetch();
$answer_id = $ar_res['ID'];

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

    // Получаем список ответов для выбранного вопроса
    $xarSelect = Array("ID", "property_incans");
    $xarFilter = Array("property_question" => $arCurrentValues['IBLOCK_QUESTION'], "IBLOCK_ID" => $answer_id);
    $xarSort = Array("property_dateans" => 'DESC');
    $xres = CIBlockElement::GetList($xarSort, $xarFilter, false, false, $xarSelect);

    $xval = Array();
    while ($xob = $xres->GetNextElement())
    {
        $xarFields = $xob->GetFields();
        $xval[$xarFields["ID"]] = "[".$xarFields["ID"]."] ".$xarFields["PROPERTY_INCANS_VALUE"];
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
	),
	"IBLOCK_ANSWER" => array(
	    "PARENT" => "BASE",
	    "NAME" => GetMessage("SELECT_AN_ANSWER"),
	    "TYPE" => "LIST",
	    "VALUES" => $xval,
	)
    )
);
