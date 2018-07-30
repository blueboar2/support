<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<div class="enclosing_comment">
<input type=hidden class="which_answer" value="<?php echo $arResult['ans']; ?>">

        <button class="sup2_but" onclick='dge = document.getElementById("<?php echo $arResult['md5']; ?>"); dge.style.display = (dge.style.display == "none") ? "block" : "none";'>Комментарии (<?php echo(count($arResult['comments'])); ?>)</button>
        
        <div class="sup2_dnone" style="display: <?php if ((int) $arResult['exp'] == 1) {echo "block";} else {echo "none";} ?>;" id="<?php echo $arResult['md5']; ?>">

            <?php
            foreach ($arResult['comments'] as $comment)
            {
            $APPLICATION->IncludeComponent(
        	"support:support.commentscard",
        	"",
        	Array(
        	"IBLOCK_ANSWER" => $arResult['ans'],
        	"IBLOCK_COMMENT" => $comment['id']
        	)
            );
            }

            $APPLICATION->IncludeComponent(
        	"support:support.commentsadd",
        	"",
        	Array(
        	"IBLOCK_ANSWER" => $arResult['ans'],
        	"IBLOCK_QUESTION" => $arResult['ourquestion']
        	)
            );

?>
	</div>

</div>	