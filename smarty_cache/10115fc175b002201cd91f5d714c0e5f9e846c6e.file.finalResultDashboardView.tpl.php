<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:58
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\report/finalResultDashboardView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:262052406f1aea20a8-35308587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10115fc175b002201cd91f5d714c0e5f9e846c6e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\report/finalResultDashboardView.tpl',
      1 => 1379954117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '262052406f1aea20a8-35308587',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- finalResultDashboardView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['keyIdValues'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getKeyIdValues(), null, null);?>
<tr style="text-align:center;" id="detail_dashboard_<?php echo $_smarty_tpl->getVariable('valueObject')->value->getBossId();?>
" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="alternate" style="text-align:left;">
        <?php echo NameConverter::display($_smarty_tpl->getVariable('valueObject')->value->getBossName());?>

    </td>
    <td class="icon-link">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEmployeesTotal());?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getTotalDetailLink();?>
</span>
    </td>
    <td class="seperator">&nbsp;</td>
    <?php  $_smarty_tpl->tpl_vars['keyIdValue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keyIdValues')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyIdValue']->key => $_smarty_tpl->tpl_vars['keyIdValue']->value){
?>
    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable($_smarty_tpl->getVariable('keyIdValue')->value->getDatabaseId(), null, null);?>
    <td class="icon-link <?php if ($_smarty_tpl->getVariable('valueObject')->value->isNotAssessedScoreId($_smarty_tpl->getVariable('key')->value)){?> alternate<?php }?>">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEmployeeCountForKey($_smarty_tpl->getVariable('key')->value));?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getKeyDetailLink($_smarty_tpl->getVariable('key')->value);?>

    </td>
    <?php }} ?>
</tr>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showDebug()){?>
<tr>
    <td colspan="100%">
        <pre><?php echo print_r($_smarty_tpl->getVariable('valueObject')->value,true);?>
</pre>
    </td>
</tr>
<?php }?>
<!-- /finalResultDashboardView.tpl -->