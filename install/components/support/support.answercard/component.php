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

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'authors'),
	true);
	
$ar_res = $res->Fetch();
$author_id = $ar_res['ID'];

$res = CIBlock::GetList(
	Array(),
	Array('CODE' => 'comments'),
	true);
	
$ar_res = $res->Fetch();
$comment_id = $ar_res['ID'];


$ouranswerid = $arParams["IBLOCK_ANSWER"];
$ourquestionid = $arParams["IBLOCK_ANSWER"];

$arSelect = Array("ID", "property_incans", "property_dateans", "property_authorans");
$arFilter = Array("ID" => $ouranswerid, "IBLOCK_ID" => $answer_id);
$arSort = Array("property_dateans" => "DESC");
$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

// Сюда будем заносить данные об ответах на него
while ($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();

    $ansid = $arFields["ID"];
    $arResult['incans'] = $arFields["PROPERTY_INCANS_VALUE"];
    $arResult['dateans'] = $arFields["PROPERTY_DATEANS_VALUE"];
    $arResult['id'] = $arFields["ID"];
    
    $arResult['md5'] = md5($ansid);
    
    $cid = $arFields["PROPERTY_AUTHORANS_VALUE"];
    
    $arSelect = Array("property_name");
    $arFilter = Array("ID" => $cid, "IBLOCK_ID" => $author_id);
    $resx = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    
    $rresx = $resx->GetNextElement()->GetFields();
    $arResult['authorans'] = $rresx["PROPERTY_NAME_VALUE"];
}

global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/components/support/support.answercard/css/template.css");

$this->IncludeComponentTemplate();
?>
