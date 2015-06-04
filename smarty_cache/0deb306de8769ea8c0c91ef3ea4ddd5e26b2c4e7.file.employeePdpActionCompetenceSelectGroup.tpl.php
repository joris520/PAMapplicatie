<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:26
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/pdpAction/employeePdpActionCompetenceSelectGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10221556ffc761b8f98-11273185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0deb306de8769ea8c0c91ef3ea4ddd5e26b2c4e7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/pdpAction/employeePdpActionCompetenceSelectGroup.tpl',
      1 => 1433243737,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10221556ffc761b8f98-11273185',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeePdpActionCompetenceSelectGroup.tpl -->
<?php $_smarty_tpl->tpl_vars['isFirst'] = new Smarty_variable(true, null, null);?>
<div style=" background-color:white;width:680px;height:200px; overflow:auto;">
    <table style="padding: 4px;width:650px;">
    <?php  $_smarty_tpl->tpl_vars['categoryInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['categoryInterfaceObject']->key => $_smarty_tpl->tpl_vars['categoryInterfaceObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('categoryInterfaceObject')->value->fetchHtml();?>

        <?php $_smarty_tpl->tpl_vars['isFirst'] = new Smarty_variable(false, null, null);?>
    <?php }} ?>
    </table>
</div>
<!-- /employeePdpActionCompetenceSelectGroup.tpl -->