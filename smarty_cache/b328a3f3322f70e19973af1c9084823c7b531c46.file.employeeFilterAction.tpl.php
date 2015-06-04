<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:12
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\list/employeeFilterAction.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16304557013d85ab834-60694326%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b328a3f3322f70e19973af1c9084823c7b531c46' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\list/employeeFilterAction.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16304557013d85ab834-60694326',
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
