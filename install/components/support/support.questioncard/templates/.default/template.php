<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<?php if ($arResult['actques']!='Y')
       { echo "<H3>Данный вопрос не активен</H3>"; }
       else
       {
?>

<p align=justify>
<div class="sup2_question"><?php echo $arResult['incques']; ?></div>
<?php echo $arResult['dateques'];

	$APPLICATION->IncludeComponent(
	"support:support.answerlist",
	"",
	Array(
	    "IBLOCK_QUESTION" => $arResult['id']
	)
	);
	
	}
?>

