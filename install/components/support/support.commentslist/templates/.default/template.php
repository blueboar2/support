<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

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