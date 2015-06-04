<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:19:04
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\report/managerReportView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13632556ffbe85cbef0-48341909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6e6d75ae6ab49d8053dee11d676a63ef496a536' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\report/managerReportView.tpl',
      1 => 1433243587,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13632556ffbe85cbef0-48341909',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- managerReportView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['userValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getManagerUserValueObject(), null, null);?>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hiliteRow()){?>
    <?php $_smarty_tpl->tpl_vars['new_row_indicator'] = new Smarty_variable('class="short_hilite"', null, null);?>
<?php }else{ ?>
    <?php $_smarty_tpl->tpl_vars['new_row_indicator'] = new Smarty_variable('', null, null);?>
<?php }?>
<tr <?php echo $_smarty_tpl->getVariable('new_row_indicator')->value;?>
 id="detail_row_<?php echo $_smarty_tpl->getVariable('valueObject')->value->getId();?>
" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="bottom_line">
        <?php echo $_smarty_tpl->getVariable('valueObject')->value->getManagerName();?>

    </td>
    <td class="bottom_line centered icon-link">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getSubordinatesCount());?>
&nbsp; <span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEmployeeDetailLink();?>
</span>
    </td>
    <td class="bottom_line<?php if (!$_smarty_tpl->getVariable('userValueObject')->value->isActive){?> inactive<?php }?>">
        <?php echo $_smarty_tpl->getVariable('userValueObject')->value->login;?>

    </td>
    <td class="bottom_line centered<?php if (!$_smarty_tpl->getVariable('userValueObject')->value->isActive){?> inactive<?php }?>">
        <?php echo UserLevelConverter::display($_smarty_tpl->getVariable('userValueObject')->value->userLevel);?>

    </td>
    <?php $_smarty_tpl->tpl_vars['accessAll'] = new Smarty_variable($_smarty_tpl->getVariable('userValueObject')->value->accessAllDepartments==constant('ALWAYS_ACCESS_ALL_DEPARTMENTS'), null, null);?>
    <td class="bottom_line centered <?php if (!$_smarty_tpl->getVariable('accessAll')->value){?>icon-link<?php }?><?php if (!$_smarty_tpl->getVariable('userValueObject')->value->isActive){?> inactive<?php }?>">
        <?php if ($_smarty_tpl->getVariable('accessAll')->value){?><?php echo TXT_UCF('ALL_DEPARTMENTS');?>

        <?php }else{ ?>
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('userValueObject')->value->departmentCount);?>
&nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDepartmentDetailLink();?>
</span>
        <?php }?>
    </td>
</tr>
<!-- /managerReportView.tpl -->