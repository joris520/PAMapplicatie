<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:12
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\list/employeeFilterView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28201557013d86e47b9-86236470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c86834fc4286fa0ceadf4e0f4203604e8a2a904d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\list/employeeFilterView.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28201557013d86e47b9-86236470',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeFilterView.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showSearch()){?>
<table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <tr>
        <td>
            <input type="text" name="search_employee" name="search_employee" size="25" maxlength="250" value="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEmployeeSearchValue();?>
" onkeyup="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
">
            <a href="" onClick="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
"><img src="<?php echo constant('ICON_SEARCH');?>
" title="<?php echo TXT_UCF('SEARCH_EMPLOYEE');?>
" alt="search" class="icon-style" /></a>
        </td>
    </tr>
</table>
<?php }?>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showFilters()){?>
<div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getReplaceActionHtmlId();?>
" style="padding:3px">
    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getFilterActionHtml();?>

</div>
<div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getReplaceFormHtmlId();?>
">
    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getFilterDetailHtml();?>

</div>
<?php }?>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showSearch()||$_smarty_tpl->getVariable('interfaceObject')->value->showFilters()){?>
<hr />
<?php }?>
<!-- /employeeFilterView.tpl -->