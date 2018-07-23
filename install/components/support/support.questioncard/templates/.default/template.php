<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<?php if ($arResult['actques']!='Y')
       { echo "<H3>Данный вопрос не активен</H3>"; }
       else
       {
?>

<p align=justify>

<div class="sup2_question"><?php echo $arResult['incques']; ?></div>
<?php echo $arResult['dateques']; ?>

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
	)
?>    

        <button class="sup2_but" onclick='dge = document.getElementById("<?php echo $answer['md5']; ?>"); dge.style.display = (dge.style.display == "none") ? "block" : "none";'>Комментарии (<?php echo(count($answer['comments'])); ?>)</button>
        
        <div class="sup2_dnone" style="display: none;" id="<?php echo $answer['md5']; ?>">
        
    <?php
	$APPLICATION->IncludeComponent(
	"support:support.commentslist",
	"",
	Array(
	    "IBLOCK_ANSWER" => $answer['id'],
	    "IBLOCK_QUESTION" => $arResult['id']
	)
	)
    ?>

	</div>
    <?php
        }
    ?>

<p>
Добавить сюда форму добавления ответа<BR>

<?php
	}
?>
