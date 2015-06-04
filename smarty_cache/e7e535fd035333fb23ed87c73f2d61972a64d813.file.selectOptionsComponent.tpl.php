<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:30:44
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\components/selectOptionsComponent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18968556ffea4889747-24458489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7e535fd035333fb23ed87c73f2d61972a64d813' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\components/selectOptionsComponent.tpl',
      1 => 1433243580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18968556ffea4889747-24458489',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- selectOptionsComponent.tpl -->
<?php if (!$_smarty_tpl->getVariable('required')->value){?>
    <option value="">- <?php echo TXT_LC('SELECT');?>
<?php if (!empty($_smarty_tpl->getVariable('subject',null,true,false)->value)){?> <?php echo $_smarty_tpl->getVariable('subject')->value;?>
<?php }?> -</option>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('values')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
?>
    <?php $_smarty_tpl->tpl_vars['display'] = new Smarty_variable(call_user_func(($_smarty_tpl->getVariable('converter')->value).('::display'),$_smarty_tpl->tpl_vars['value']->value), null, null);?>
    <?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(call_user_func(($_smarty_tpl->getVariable('converter')->value).('::description'),$_smarty_tpl->tpl_vars['value']->value), null, null);?>
    <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" <?php if ($_smarty_tpl->getVariable('currentValue')->value==$_smarty_tpl->tpl_vars['value']->value){?>selected<?php }?><?php if (!empty($_smarty_tpl->getVariable('title',null,true,false)->value)){?> title="<?php echo $_smarty_tpl->getVariable('title')->value;?>
"<?php }?>><?php echo $_smarty_tpl->getVariable('display')->value;?>
</option>
<?php }} ?>
<!-- /selectOptionsComponent.tpl -->
