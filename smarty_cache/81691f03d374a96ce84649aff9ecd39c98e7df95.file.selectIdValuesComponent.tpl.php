<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:30:44
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\components/selectIdValuesComponent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27131556ffea4721ed5-05607088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81691f03d374a96ce84649aff9ecd39c98e7df95' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\components/selectIdValuesComponent.tpl',
      1 => 1433243580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27131556ffea4721ed5-05607088',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- selectIdValuesComponent.tpl -->
<?php if (!$_smarty_tpl->getVariable('required')->value){?>
    <option value="">- <?php echo TXT_LC('SELECT');?>
<?php if (!empty($_smarty_tpl->getVariable('subject',null,true,false)->value)){?> <?php echo $_smarty_tpl->getVariable('subject')->value;?>
<?php }?> -</option>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['idValue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('idValues')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['idValue']->key => $_smarty_tpl->tpl_vars['idValue']->value){
?>
<option value="<?php echo $_smarty_tpl->getVariable('idValue')->value->getDatabaseId();?>
" <?php if ($_smarty_tpl->getVariable('currentValue')->value==$_smarty_tpl->getVariable('idValue')->value->getDatabaseId()){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('idValue')->value->getValue();?>
</option>
<?php }} ?>
<!-- /selectIdValuesComponent.tpl -->