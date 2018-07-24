<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); 

$somehash = md5(rand());
?>

<H3>Задать новый вопрос</H3>

<p align=justify>
<FORM id="<?php echo $somehash; ?>" method="POST">
<?php
    if ($arResult['isa'] == 0)
	{
	echo '<INPUT style="width:60%;" id="name_'.$somehash.'" value="Ваше имя"><BR><BR>';
	echo '<INPUT style="width:60%;" id="email_'.$somehash.'" value="Ваш e-mail"><BR><BR>';
	}
	else
	{
	echo '<INPUT type=hidden id="name_'.$somehash.'" value="'.$arResult['fname'].'">';
	echo '<INPUT type=hidden id="email_'.$somehash.'" value="'.$arResult['email'].'">';
	};
?>	
<TEXTAREA style="width:60%; height: 100;" id="tarea_<?php echo $somehash;?>">Ваш вопрос</TEXTAREA><BR>
<div style="display: none; padding-top: 10px; padding-bottom: 10px;" id="status_<?php echo $somehash; ?>"></div>

<BR>
<INPUT onclick='ajax_new_question("<?php echo $somehash; ?>"); event.preventDefault(); ' type="submit" value="Отправить">
</FORM>

