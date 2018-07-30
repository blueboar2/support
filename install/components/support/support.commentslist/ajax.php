<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

	$APPLICATION->IncludeComponent(
	"support:support.commentslist",
	"",
	Array(
	    "IBLOCK_QUESTION" => (int) $_POST['id_que'],
	    "IBLOCK_ANSWER" => (int) $_POST['id_ans'],
	    "EXPAND" => 1
	)
	);
?>
