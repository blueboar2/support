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

$ourquestionid = $arParams["IBLOCK_QUESTION"];

$arSelect = Array("property_endques", "property_actques", "property_incques", "property_dateques", "property_authorques");
$arFilter = Array("ID" => $ourquestionid, "IBLOCK_ID" => $question_id);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$ob = $res->GetNextElement()->GetFields();

// Заносим все данные о выбранном вопросе
$arResult = Array();
$arResult["id"] = $ob["ID"];
$arResult["endques"] = $ob["PROPERTY_ENDQUES_VALUE"];
$arResult["actques"] = $ob["PROPERTY_ACTQUES_VALUE"];
$arResult["incques"] = $ob["PROPERTY_INCQUES_VALUE"];
$arResult["dateques"] = $ob["PROPERTY_DATEQUES_VALUE"];

$arSelect = Array("property_name");
$arFilter = Array("ID" => $ob["PROPERTY_AUTHORQUES_VALUE"], "IBLOCK_ID" => $author_id);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$ob = $res->GetNextElement()->GetFields();
$arResult["authorques"] = $ob["PROPERTY_NAME_VALUE"];

$arSelect = Array("ID", "property_incans", "property_dateans", "property_authorans");
$arFilter = Array("property_question.ID" => $ourquestionid, "IBLOCK_ID" => $answer_id);
$arSort = Array("property_dateans" => "DESC");
$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

// Сюда будем заносить данные об ответах на него
$answers = Array();

while ($ob = $res->GetNextElement())
{
    $ans = Array();

    $arFields = $ob->GetFields();

    $ansid = $arFields["ID"];
    $ans['incans'] = $arFields["PROPERTY_INCANS_VALUE"];
    $ans['dateans'] = $arFields["PROPERTY_DATEANS_VALUE"];
    $ans['id'] = $arFields["ID"];
    
    $ans['md5'] = md5($ansid);
    
    $cid = $arFields["PROPERTY_AUTHORANS_VALUE"];
    
    $arSelect = Array("property_name");
    $arFilter = Array("ID" => $cid, "IBLOCK_ID" => $author_id);
    $resx = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    
    $rresx = $resx->GetNextElement()->GetFields();
    $ans['authorans'] = $rresx["PROPERTY_NAME_VALUE"];

    // Сюда будем заносить данные о комментариях к ответу
    $comments = Array();

        $arSelect = Array("property_inccom", "property_datecom", "property_authorcom");
        $arFilter = Array("property_answer.ID" => $ansid, "IBLOCK_ID" => $comment_id);
        $arSort = Array("property_datecom" => "DESC");
        $yres = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

        while ($yob = $yres->GetNextElement())
        {
            $coms = Array();

            $arFields = $yob->GetFields();
            $coms['inccom'] = $arFields["PROPERTY_INCCOM_VALUE"];
            $coms['datecom'] = $arFields["PROPERTY_DATECOM_VALUE"];
    
            $cid = $arFields["PROPERTY_AUTHORCOM_VALUE"];
    
            $arSelect = Array("property_name");
            $arFilter = Array("ID" => $cid, "IBLOCK_ID" => $author_id);
            $resy = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    
            $rresy = $resy->GetNextElement()->GetFields();
            $coms['authorcom'] = $rresy["PROPERTY_NAME_VALUE"];
            
            // Заносим следующий комментарий
            array_push($comments, $coms);
        }

    $ans["comments"] = $comments;
    // Заносим следующий ответ
    array_push($answers, $ans);
}

$arResult["answers"] = $answers;

global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/components/support/support.questioncard/css/template.css");

$this->IncludeComponentTemplate();
?>
