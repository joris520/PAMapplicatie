<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:44
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\report/pdpActionDashboardGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:763552406f0c2479f5-41531006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63539b471b682dc9862c08ebf6c074043127b8b3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\report/pdpActionDashboardGroup.tpl',
      1 => 1379954117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '763552406f0c2479f5-41531006',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- pdpActionDashboardGroup.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['keyIdValues'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getKeyIdValues(), null, null);?>
<?php $_smarty_tpl->tpl_vars['keyColCount'] = new Smarty_variable(count($_smarty_tpl->getVariable('keyIdValues')->value), null, null);?>
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <tr>
        <th class="alternate" style="text-align:left; padding-top:10px;">&nbsp;</th>
        <th class="" colspan="2" style="padding-top:10px;"><?php echo TXT_UCF('NUMBER_OF_EMPLOYEES');?>
</th>
        <th class="seperator" style="width:20px; padding-top:10px;">&nbsp;</th>
        <th class="" colspan="<?php echo $_smarty_tpl->getVariable('keyColCount')->value;?>
" style="padding-top:10px;" title="<?php echo TXT_UCF('TITLE_NUMBER_OF_PDP_ACTIONS');?>
"><?php echo TXT_UCF('NUMBER_OF_PDP_ACTIONS');?>
</th>
    </tr>
    <tr>
        <th class="last alternate" style="text-align:left; padding-top:10px;"><?php echo TXT_UCF('MANAGER');?>
</th>
        <th class="last" style="width:80px; padding-top:10px;"><?php echo TXT_UCF('REPORT_ALL_EMPLOYEES');?>
</th>
        <th class="last" style="width:130px; padding-top:10px;"><?php echo TXT_UCF('NO_PDP_ACTIONS');?>
</th>
        <th class="seperator" style="width:20px; padding-top:10px;">&nbsp;</th>
        <?php  $_smarty_tpl->tpl_vars['keyIdValue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keyIdValues')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyIdValue']->key => $_smarty_tpl->tpl_vars['keyIdValue']->value){
?>
            <?php $_smarty_tpl->tpl_vars['keyLabel'] = new Smarty_variable($_smarty_tpl->getVariable('keyIdValue')->value->getValue(), null, null);?>
            <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable($_smarty_tpl->getVariable('keyIdValue')->value->getDatabaseId(), null, null);?>
            <th class="last<?php if ($_smarty_tpl->getVariable('key')->value==PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED){?> alternate<?php }?>" style="padding-top:10px;"><?php echo $_smarty_tpl->getVariable('keyLabel')->value;?>
</th>
        <?php }} ?>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->getCount()>0){?>
    <?php  $_smarty_tpl->tpl_vars['viewObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['viewObject']->key => $_smarty_tpl->tpl_vars['viewObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('viewObject')->value->fetchHtml();?>

    <?php }} ?>
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last" colspan="2" >&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <?php  $_smarty_tpl->tpl_vars['keyIdValue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keyIdValues')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyIdValue']->key => $_smarty_tpl->tpl_vars['keyIdValue']->value){
?>
            <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable($_smarty_tpl->getVariable('keyIdValue')->value->getDatabaseId(), null, null);?>
            <td class="last<?php if ($_smarty_tpl->getVariable('key')->value==PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED){?> alternate<?php }?>">&nbsp;</td>
        <?php }} ?>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showTotals()){?>
    <tr style="text-align:center; font-weight:bold;" id="detail_dashboard_totals" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="last alternate" style="text-align:left;">
            <?php echo TXT_UC('DASHBOARD_TOTALS');?>

        </td>
        <td class="last icon-link">
            <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEmployeesTotal());?>

            &nbsp;<span class="last activeRow icon-style "><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getTotalDetailLink();?>
</span>
        </td>
        <td class="last icon-link">
            <?php echo NumberConverter::display($_smarty_tpl->getVariable('interfaceObject')->value->getEmployeesWithout());?>

            &nbsp;<span class="last activeRow icon-style "><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getWithoutDetailLink();?>
</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        <?php  $_smarty_tpl->tpl_vars['keyIdValue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('keyIdValues')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['keyIdValue']->key => $_smarty_tpl->tpl_vars['keyIdValue']->value){
?>
        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable($_smarty_tpl->getVariable('keyIdValue')->value->getDatabaseId(), null, null);?>
        <td class="last icon-link <?php if ($_smarty_tpl->getVariable('key')->value==PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED){?> alternate<?php }?>">
            <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEmployeeCountForKey($_smarty_tpl->getVariable('key')->value));?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getKeyDetailLink($_smarty_tpl->getVariable('key')->value);?>

        </td>
        <?php }} ?>
    </tr>
    <?php }?>
    <?php }else{ ?>
    <tr>
        <td class="last" colspan="100%"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmptyMessage();?>
</td>
    </tr>
    <?php }?>
</table>
<!-- /pdpActionDashboardGroup.tpl -->