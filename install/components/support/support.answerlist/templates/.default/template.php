<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<p>
<div class="sup2_wordans"><?php echo GetMessage("SUP2_ANSWERS") ?></div>

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
	    "IBLOCK_QUESTION" => $arResult['id']
	)
	);


        }
    ?>

<p>
Добавить сюда форму добавления ответа<BR>
