<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:12
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\list/employeeListView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28495557013d88c7c87-20493729%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e09933150bed2c12a628ee6b3c9f071930e8473b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\list/employeeListView.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28495557013d88c7c87-20493729',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeListView.tpl -->
<!-- sortfilter:<?php echo EmployeeFilterService::retrieveSortFilter();?>
 -->
<div class="actions">
    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getAddLink();?>

</div>
<div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getReplaceHtmlId();?>
">
    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getFilteredEmployees()->fetchHtml();?>

</div><!-- /<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getReplaceHtmlId();?>
 -->
<!-- /employeeListView.tpl -->