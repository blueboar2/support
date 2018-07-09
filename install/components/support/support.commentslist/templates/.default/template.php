<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

            <?php
            foreach ($arResult['comments'] as $comment)
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

