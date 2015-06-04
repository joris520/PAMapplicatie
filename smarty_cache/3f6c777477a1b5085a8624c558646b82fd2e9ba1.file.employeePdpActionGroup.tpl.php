<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:20
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/pdpAction/employeePdpActionGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11579556ffc703fc7f8-65890227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f6c777477a1b5085a8624c558646b82fd2e9ba1' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/pdpAction/employeePdpActionGroup.tpl',
      1 => 1433243738,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11579556ffc703fc7f8-65890227',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeePdpActionGroup.tpl -->
<table class="content-table" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
<?php if (count($_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects())>0){?>
    <tr>
        <th class="shaded_title" width="220px"><?php echo TXT_UCF('PDP_ACTION');?>
</th>
        <th class="shaded_title" width="130px"><?php echo TXT_UCF('STATUS');?>
</th>
        <th class="shaded_title" width="110px"><?php echo TXT_UCF('DEADLINE_DATE');?>
</th>
        <th class="shaded_title" width="220px"><?php echo TXT_UCF('ACTION_OWNER');?>
</th>
        <th class="shaded_title" width="110px"><?php echo TXT_UCF('NOTIFICATION_DATE');?>
</th>
        <th class="shaded_title actions" width="50px">&nbsp;</td>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['viewInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['viewInterfaceObject']->key => $_smarty_tpl->tpl_vars['viewInterfaceObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('viewInterfaceObject')->value->fetchHtml();?>

    <?php }} ?>
<?php }else{ ?>
    <tr>
        <td colspan="100%"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmptyMessage();?>
</td>
    </tr>
<?php }?>
</table>
<!-- /employeePdpActionGroup.tpl -->