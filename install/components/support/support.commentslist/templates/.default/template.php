<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

        <button class="sup2_but" onclick='dge = document.getElementById("<?php echo $arResult['md5']; ?>"); dge.style.display = (dge.style.display == "none") ? "block" : "none";'>Комментарии (<?php echo(count($arResult['comments'])); ?>)</button>
        
        <div class="sup2_dnone" style="display: none;" id="<?php echo $arResult['md5']; ?>">

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
            ?>

	!!!Добавить сюда форму добавления комментария!!!

	</div>
	