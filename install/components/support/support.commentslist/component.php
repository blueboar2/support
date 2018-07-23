<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("support"))
	return ShowError(GetMessage("SUPPORT_MODULE_NOT_INSTALLED"));

if(!CModule::IncludeModule("iblock"))
	return ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));

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

    // Сюда будем заносить данные о комментариях к ответу
    $comments = Array();

        $arSelect = Array("ID", "property_inccom", "property_datecom", "property_authorcom");
        $arFilter = Array("property_answer.ID" => $ouranswerid, "IBLOCK_ID" => $comment_id);
        $arSort = Array("property_datecom" => "DESC");
        $yres = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

        while ($yob = $yres->GetNextElement())
        {
            $coms = Array();

            $arFields = $yob->GetFields();
            $coms['id'] = $arFields["ID"];
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

$arResult["comments"] = $comments;
$arResult["ans"] = $ouranswerid;
$arResult["md5"] = md5($ouranswerid);

global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/components/support/support.commentslist/css/template.css");

$this->IncludeComponentTemplate();
?>
