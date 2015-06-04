<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:34
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\list/employeeFilterAction.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19453556ffbcaad4f48-40427726%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44ab1e5f118d41d675c8b4ff88b60a2f0c83e19a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\list/employeeFilterAction.tpl',
      1 => 1433243584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19453556ffbcaad4f48-40427726',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- /employeeFilterAction.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showFilters()){?>
<div class="actions<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->warnActiveFilters()){?> warning<?php }?>" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
   <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getFilterLabel();?>
&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getFilterToggleLink();?>

</div>
<?php }?>
<!-- /employeeFilterAction.tpl -->
