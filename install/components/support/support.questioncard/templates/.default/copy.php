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
    ?>
        <div class="sup2_author"><?php echo($answer['authorans']); ?></div>
        <div class="sup2_answer"><?php echo($answer['incans']); ?></div>
        <div class="sup2_dateans"><?php echo($answer['dateans']); ?></div>

        <button class="sup2_but" onclick='dge = document.getElementById("<?php echo $answer['md5']; ?>"); dge.style.display = (dge.style.display == "none") ? "block" : "none";'>Комментарии (<?php echo(count($answer['comments'])); ?>)</button>
        
        <div class="sup2_dnone" style="display: none;" id="<?php echo $answer['md5']; ?>">
        
            <?php
            foreach ($answer['comments'] as $comment)
            {
            ?>
            
            <TABLE width=100% border=0 cellpadding=0 cellspacing=0>
            <TR>
            <TD><div class="sup2_comment"><?php echo $comment['authorcom'] ?></div></TD>
            <TD width=15%><div class="sup2_date"><?php echo $comment['datecom'] ?></div></TD>
            </TR>
            </TABLE>
            <div class="sup2_commenttext"><?php echo $comment['inccom']; ?></div>
            
            <?php
            }
            ?>

            Добавить сюда форму добавления комментария<BR>
            <p>
            </div>

    <?php
        }
    ?>

<p>
Добавить сюда форму добавления ответа<BR>

<?php
	}
?>
