<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:26
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\components/selectRadioComponent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1596352406efaed5fe2-94420911%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21fd73847ac1a018c0aa201527ae9caa6ce18119' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\components/selectRadioComponent.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1596352406efaed5fe2-94420911',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- selectRadioComponent.tpl -->
<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('values')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
?>
    <?php $_smarty_tpl->tpl_vars['display'] = new Smarty_variable(call_user_func(($_smarty_tpl->getVariable('converter')->value).('::input'),$_smarty_tpl->tpl_vars['value']->value), null, null);?>
    <?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(call_user_func(($_smarty_tpl->getVariable('converter')->value).('::description'),$_smarty_tpl->tpl_vars['value']->value), null, null);?>
    <input  id="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" type="radio" name="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
"  <?php if ($_smarty_tpl->tpl_vars['value']->value==$_smarty_tpl->getVariable('currentValue')->value){?> checked <?php }?>>
    <label for="<?php echo $_smarty_tpl->getVariable('inputName')->value;?>
_<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
"<?php if (!empty($_smarty_tpl->getVariable('title',null,true,false)->value)){?> title="<?php echo $_smarty_tpl->getVariable('title')->value;?>
"<?php }?>><?php echo $_smarty_tpl->getVariable('display')->value;?>
</label>&nbsp;
<?php }} ?>
<!-- /selectRadioComponent.tpl -->
