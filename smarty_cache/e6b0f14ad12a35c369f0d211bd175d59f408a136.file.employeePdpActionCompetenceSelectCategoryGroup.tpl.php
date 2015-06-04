<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:21:26
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/pdpAction/employeePdpActionCompetenceSelectCategoryGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26146556ffc762889e5-60643871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6b0f14ad12a35c369f0d211bd175d59f408a136' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/pdpAction/employeePdpActionCompetenceSelectCategoryGroup.tpl',
      1 => 1433243737,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26146556ffc762889e5-60643871',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeePdpActionCompetenceSelectCategoryGroup.tpl -->
<?php if (!$_smarty_tpl->getVariable('isFirst')->value){?>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
<?php }?>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showCategory()){?>
    <tr>
        <td colspan="3"><h2><?php echo CategoryConverter::display($_smarty_tpl->getVariable('interfaceObject')->value->getCategoryName());?>
</h2></td>
    </tr>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['clusterInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['clusterInterfaceObject']->key => $_smarty_tpl->tpl_vars['clusterInterfaceObject']->value){
?>
    <?php echo $_smarty_tpl->getVariable('clusterInterfaceObject')->value->fetchHtml();?>

<?php }} ?>
<!-- /employeePdpActionCompetenceSelectCategoryGroup.tpl -->