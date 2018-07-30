<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<div class="enclosing_ans">
<input type=hidden class="which_question" value="<?php echo $arResult['id']; ?>" >
<p>
<div class="sup2_wordans"><?php echo GetMessage("SUP2_ANSWERS") ?>

</div>

    <?php
        foreach ($arResult['answers'] as $answer)
        {

	$APPLICATION->IncludeComponent(
	"support:support.answercard",
	"",
	Array(
	    "IBLOCK_ANSWER" => $answer['id'],
	    "IBLOCK_QUESTION" => $arResult['id']
	)
	);

	$APPLICATION->IncludeComponent(
	"support:support.commentslist",
	"",
	Array(
	    "IBLOCK_ANSWER" => $answer['id'],
	    "IBLOCK_QUESTION" => $arResult['id'],
	    "EXPAND" => 0
	)
	);

	}
?>
<p>
<?php

	$APPLICATION->IncludeComponent(
	"support:support.answeradd",
	"",
	Array(
	    "IBLOCK_QUESTION" => $arResult['id']
	)
	);


?>

<BR>
</div>
