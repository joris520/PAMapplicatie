<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:43:36
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\employee/employeeInfoHeaderGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1468955701dc8c75f47-08027333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a49ae6dcc57dfd507c77a5be13b28ad041383f7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\employee/employeeInfoHeaderGroup.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1468955701dc8c75f47-08027333',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeInfoHeaderGroup.tpl -->
<div class="application-content block-title" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php $_smarty_tpl->tpl_vars['infoInterfaceObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getInfoInterfaceObject(), null, null);?>
    <?php echo $_smarty_tpl->getVariable('infoInterfaceObject')->value->fetchHtml();?>

    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showJobProfile()){?>
    <div style="height:5px;"></div>
    <?php $_smarty_tpl->tpl_vars['jobProfileInterfaceObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getJobProfileInterfaceObject(), null, null);?>
    <?php echo $_smarty_tpl->getVariable('jobProfileInterfaceObject')->value->fetchHtml();?>

    <?php }?>
</div>
<!-- /employeeInfoHeaderGroup.tpl -->