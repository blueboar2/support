<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<H3>Задать новый вопрос</H3>

<p align=justify>
<FORM id="qadd" method="POST">
<?php
    if ($arResult['isa'] == 0)
	{
	echo '<INPUT style="width:60%;" id="name" value="Ваше имя"><BR><BR>';
	echo '<INPUT style="width:60%;" id="email" value="Ваш e-mail"><BR><BR>';
	}
	else
	{
	echo '<INPUT type=hidden id="name" value="'.$arResult['fname'].'">';
	echo '<INPUT type=hidden id="email" value="'.$arResult['email'].'">';
	};
?>	
<TEXTAREA style="width:60%; height: 100;" id="tarea">Ваш вопрос</TEXTAREA><BR>
<div style="display: none; padding-top: 10px; padding-bottom: 10px;" id="status"></div>

<BR>
<INPUT onclick='ajax_new_question(); event.preventDefault(); ' type="submit" value="Отправить">
</FORM>

