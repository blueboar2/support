<?php

function unicode_decode($str) {
    $temp = preg_replace('/\%u([0-9a-f]{4})/i', "&#x$1;", $str);
    return mb_convert_encoding($temp, 'UTF-8', 'HTML-ENTITIES');    
}

require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("support");
CModule::IncludeModule("iblock");

$res = CIBlock::GetList(
    Array(),
    Array('CODE' => 'authors'),
    true);
$ar_res = $res->Fetch();
$author_id = $ar_res['ID'];

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

$property_enums = CIBlockPropertyEnum::GetList(
    Array("DEF" => "DESC", "SORT" => "ASC"),
    Array("IBLOCK_ID" => $question_id, "CODE"=>"actques"));
$enum_fields = $property_enums->GetNext();
$actques_y = $enum_fields["ID"];

$property_enums = CIBlockPropertyEnum::GetList(
    Array("DEF" => "DESC", "SORT" => "ASC"),
    Array("IBLOCK_ID" => $question_id, "CODE"=>"endques"));
$enum_fields = $property_enums->GetNext();
$endques_y = $enum_fields["ID"];

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tarea']) && isset($_POST['hash']) && isset($_POST['qu']))
    {
    $sname = htmlspecialchars(unicode_decode($_POST['name']));
    $semail = htmlspecialchars(unicode_decode($_POST['email']));
    $starea = htmlspecialchars(unicode_decode($_POST['tarea']));
    $shash = htmlspecialchars(unicode_decode($_POST['hash']));
    $squ = htmlspecialchars(unicode_decode($_POST['qu']));
    
    $arSelect = Array("name", "email");
    $arFilter = Array("property_name" => $sname, "property_email" => $semail, "IBLOCK_ID" => $author_id);
    $arSort = Array("property_name" => "DESC");
    $res = CIBlockElement::GetList($arSort, $arFilter, Array(), false, $arSelect);

    if ($res == 0)
	{
	// Данного пользователя нужно занести в базу
	$el = new CIBlockElement;
	$PROP = array();
	$PROP['name'] = $sname;
	$PROP['email'] = $semail;
	
	$arLoadProductArray = Array(
	    "MODIFIED_BY" => $USER->GetID(),
	    "CODE" => substr(md5(rand()), 0, 10),
	    "IBLOCK_ID" => $author_id,
	    "PROPERTY_VALUES" => $PROP,
	    "NAME" => $sname." ".$semail,
	    "ACTIVE" => "Y",
	);
	
	$authorid = $el->Add($arLoadProductArray);
	
	}
	else
	{
	// Получаем ID нашего пользователя

        $arSelect = Array("ID");
        $arFilter = Array("property_name" => $sname, "property_email" => $semail, "IBLOCK_ID" => $author_id);
        $arSort = Array("property_name" => "DESC");
        $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        
        while ($ob = $res->GetNext())
        	{
        	$authorid = $ob['ID'];
        	}
	}

	// Проверяем, а можно ли отвечать на данный вопрос
	
        $arSelect = Array("actques", "endques");
        $arFilter = Array("ID" => (int) $squ, "IBLOCK_ID" => $question_id);
        $arSort = Array("property_actques" => "DESC");
        $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
        
        while ($ob = $res->GetNext())
        	{
        	$aques = $ob['PROPERTY_ACTQUES_VALUE'];
        	$eques = $ob['PROPERTY_ENDQUES_VALUE'];
        	}
	
	if ($aques!='Y' || $eques=='Y')
	{
	echo "ERROR:".$shash.":".$squ;
	}
	else
	{
	// Заносим в базу новый ответ
	$el = new CIBlockElement;
	$PROP = array();
	$PROP['authorans'] = $authorid;
	$PROP['question'] = (int) $squ;	
	$PROP['incans'] = $starea;
	$PROP['dateans'] = date("d.m.Y H:i:s");
	
	$arLoadProductArray = Array(
	    "MODIFIED_BY" => $USER->GetID(),
	    "CODE" => substr(md5(rand()), 0, 10),
	    "IBLOCK_ID" => $answer_id,
	    "PROPERTY_VALUES" => $PROP,
	    "NAME" => $sname." ".$semail,
	    "ACTIVE" => "Y",
	);
	
	$answerid = $el->Add($arLoadProductArray);
	
	echo "OK:".$shash.":".$squ;
	}
    }
    else
    {
    echo "ERROR:".$shash.":".$squ;
    }
?>