<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("support"))
	return ShowError(GetMessage("SUPPORT_MODULE_NOT_INSTALLED"));

if(!CModule::IncludeModule("iblock"))
	return ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));


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

$arSelect = Array("ID", "property_incques", "property_dateques");
$arFilter = Array("!property_endques_value" => "Y", "IBLOCK_ID" => $question_id);
$arSort = Array("property_dateques" => 'DESC');
$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

$arResult = Array();

while ($ob = $res->GetNextElement())
{
    $quest = Array();

    $arFields = $ob->GetFields();
    $quest['QUESTION'] = $arFields["PROPERTY_INCQUES_VALUE"];
    $quest['DATE'] = $arFields["PROPERTY_DATEQUES_VALUE"];
    
    $cid = $arFields["ID"];
    $arSelect = Array("ID");
    $arFilter = Array("property_question.ID" => $cid, "IBLOCK_ID" => $answer_id);
    $resx = CIBlockElement::GetList(Array(), $arFilter, Array(), false, $arSelect);
    $quest['ANSWER'] = $resx;
    
    array_push($arResult, $quest);
    
}

global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/components/support/support.questionlist/css/template.css");

$this->IncludeComponentTemplate();
?>