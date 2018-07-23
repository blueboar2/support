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

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'comments'),
	true);
$ar_res = $res->Fetch();
$comment_id = $ar_res['ID'];

    // Получаем список всех ответов
    $xarSelect = Array("ID", "property_incans");
    $xarFilter = Array("IBLOCK_ID" => $answer_id);
    $xarSort = Array("property_dateans" => 'DESC');
    $xres = CIBlockElement::GetList($xarSort, $xarFilter, false, false, $xarSelect);

    $xval = Array();
    while ($xob = $xres->GetNextElement())
    {
        $xarFields = $xob->GetFields();
        $xval[$xarFields["ID"]] = "[".$xarFields["ID"]."] ".$xarFields["PROPERTY_INCANS_VALUE"];
    }

    // Получаем список комментариев для выбранного ответа
    $yarSelect = Array("ID", "property_inccom");
    $yarFilter = Array("property_answer" => $arCurrentValues['IBLOCK_ANSWER'], "IBLOCK_ID" => $comment_id);
    $yarSort = Array("property_datecom" => 'DESC');
    $yres = CIBlockElement::GetList($yarSort, $yarFilter, false, false, $yarSelect);

    $yval = Array();
    while ($yob = $yres->GetNextElement())
    {
        $yarFields = $yob->GetFields();
        $yval[$yarFields["ID"]] = "[".$yarFields["ID"]."] ".$yarFields["PROPERTY_INCCOM_VALUE"];
    }

$arComponentParameters = array(
    "GROUPS" => array(
	"BASE" => array(
	    "NAME" => GetMessage("STANDARD_SETTINGS")
	)
    ),
    "PARAMETERS" => array(
	"IBLOCK_ANSWER" => array(
	    "PARENT" => "BASE",
	    "NAME" => GetMessage("SELECT_AN_ANSWER"),
	    "TYPE" => "LIST",
	    "VALUES" => $xval,
	    "REFRESH" => "Y"
	),
	"IBLOCK_COMMENT" => array(
	    "PARENT" => "BASE",
	    "NAME" => GetMessage("SELECT_A_COMMENT"),
	    "TYPE" => "LIST",
	    "VALUES" => $yval,
	),
	
    )
);
