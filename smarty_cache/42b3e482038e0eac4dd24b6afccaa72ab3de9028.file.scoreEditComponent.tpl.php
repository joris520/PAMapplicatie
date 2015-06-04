<?php /* Smarty version Smarty-3.0.7, created on 2014-05-27 15:48:50
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\components/scoreEditComponent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7161538497c2934c14-12573153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42b3e482038e0eac4dd24b6afccaa72ab3de9028' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\components/scoreEditComponent.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7161538497c2934c14-12573153',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- scoreEditComponent.tpl -->
<?php if (!empty($_smarty_tpl->getVariable('keepAliveCallback',null,true,false)->value)){?>
<?php $_smarty_tpl->tpl_vars['onClickFunction'] = new Smarty_variable((('onClick="').($_smarty_tpl->getVariable('keepAliveCallback')->value)).(';"'), null, null);?>
<?php }?>
    <?php if ($_smarty_tpl->getVariable('scaleType')->value==ScaleValue::SCALE_Y_N){?>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_y" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_Y;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_Y){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_y" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_Y);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_Y);?>
</label>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_n" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_N;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_N){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_n" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_N);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_N);?>
</label>
        <?php if ($_smarty_tpl->getVariable('isEmptyAllowed')->value){?>
        &nbsp;&nbsp;&nbsp;
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_na" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::INPUT_SCORE_NA;?>
" <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_NA){?> checked <?php }?>>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_na"><?php echo ScoreConverter::input(ScoreValue::SCORE_NA);?>
</label>
        <?php }?>
    <?php }else{ ?>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_1" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_1;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_1){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_1" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_1);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_1);?>
</label>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_2" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_2;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_2){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_2" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_2);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_2);?>
</label>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_3" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_3;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_3){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_3" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_3);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_3);?>
</label>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_4" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_4;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_4){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_4" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_4);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_4);?>
</label>
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_5" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::SCORE_5;?>
"  <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_5){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_5" title="<?php echo ScoreConverter::display(ScoreValue::SCORE_5);?>
"><?php echo ScoreConverter::input(ScoreValue::SCORE_5);?>
</label>
        <?php if ($_smarty_tpl->getVariable('isEmptyAllowed')->value){?>
        &nbsp;&nbsp;&nbsp;
        <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_na" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo ScoreValue::INPUT_SCORE_NA;?>
" <?php if ($_smarty_tpl->getVariable('score')->value==ScoreValue::SCORE_NA){?> checked <?php }?> <?php echo $_smarty_tpl->getVariable('onClickFunction')->value;?>
>
        <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_na"><?php echo ScoreConverter::input(ScoreValue::SCORE_NA);?>
</label>
        <?php }?>
    <?php }?>
<!-- scoreEditComponent.tpl -->
