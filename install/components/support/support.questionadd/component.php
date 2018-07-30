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
	

global $USER;
if ($USER->IsAuthorized())
    {
    $arResult['isa'] = 1;
    $arResult['fname'] = $USER->GetFullName();
    $arResult['email'] = $USER->GetEmail();
    }
else
    {
    $arResult['isa'] = 0;
    };
    
CAjax::Init();
$this->IncludeComponentTemplate();
?>
