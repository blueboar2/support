<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!=true)die(); ?>

<div class="sup_questionlist">

<?php
       foreach ($arResult as $quest)
       {
?>

<div class="sup_conc_ques">
     <div class="sup_question">
     <?php echo $quest['QUESTION']; ?>
     </div>
     <?php echo $quest['DATE']; ?>
</div>
<div class="sup_conc_ans">
     <div class="sup_answer">
     <?php echo $quest['ANSWER']; ?>
     </div>
     <?php $ed = $quest['ANSWER'] % 10;
           switch($ed) {
               case 1: echo GetMessage("ANS_FORM1");
                       break;
               case 2:
               case 3:
               case 4: echo GetMessage("ANS_FORM2");
                       break;
               default: echo GetMessage("ANS_FORM3");
               };
    ?>
</div>
<div class="sup_clear"></div>

<?php
       }
?>

</div>