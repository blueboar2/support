<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

	$APPLICATION->IncludeComponent(
	"support:support.answerlist",
	"",
	Array(
	    "IBLOCK_QUESTION" => (int) $_POST['id']
	)
	);
?>
