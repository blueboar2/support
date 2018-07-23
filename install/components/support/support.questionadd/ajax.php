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

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tarea']))
    {
    $sname = htmlspecialchars(unicode_decode($_POST['name']));
    $semail = htmlspecialchars(unicode_decode($_POST['email']));
    $starea = htmlspecialchars(unicode_decode($_POST['tarea']));
    
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

	// Заносим в базу новый вопрос
	$el = new CIBlockElement;
	$PROP = array();
	$PROP['authorques'] = $authorid;
	$PROP['incques'] = $starea;
	$PROP['dateques'] = date("d.m.Y H:i:s");
	$PROP['actques'] = Array("VALUE" => $actques_y);
	$PROP['endques'] = false;
	
	$arLoadProductArray = Array(
	    "MODIFIED_BY" => $USER->GetID(),
	    "CODE" => substr(md5(rand()), 0, 10),
	    "IBLOCK_ID" => $question_id,
	    "PROPERTY_VALUES" => $PROP,
	    "NAME" => $sname." ".$semail,
	    "ACTIVE" => "Y",
	);
	
	$questionid = $el->Add($arLoadProductArray);
	
	echo "OK";
    }
    else
    {
    echo "ERROR";
    }
?>