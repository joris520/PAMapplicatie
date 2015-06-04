<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:43:37
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\employee/profile/employeeProfileOrganisationView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:283455701dc99fd970-90178094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a032bd19bd3e5a59b9f4bda058e01fe08445d320' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\employee/profile/employeeProfileOrganisationView.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '283455701dc99fd970-90178094',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeProfileOrganisationView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['styleLabelWidth'] = new Smarty_variable('style="width:220px;"', null, null);?>
<table class="content-table employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;" >
    <tr>
        <td class="content-label" <?php echo $_smarty_tpl->getVariable('styleLabelWidth')->value;?>
><?php echo TXT_UCF('DEPARTMENT');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('valueObject')->value->getDepartmentName();?>
</td>
    </tr>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('BOSS');?>
:</td>
        <td class="content-value"><?php echo NameConverter::display($_smarty_tpl->getVariable('valueObject')->value->getBossEmployeeName());?>
</td>
    </tr>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('IS_SELECTABLE_AS_BOSS');?>
:</td>
        <?php $_smarty_tpl->tpl_vars['subordinateDisplay'] = new Smarty_variable(EmployeeIsBossConverter::description($_smarty_tpl->getVariable('valueObject')->value->getIsBossValue(),$_smarty_tpl->getVariable('valueObject')->value->getBossSubordinateCount()), null, null);?>
        <td class="content-value"><?php echo EmployeeIsBossConverter::display($_smarty_tpl->getVariable('valueObject')->value->getIsBossValue());?>
<?php if ($_smarty_tpl->getVariable('valueObject')->value->isBoss()){?>&nbsp;&nbsp;<em><?php echo $_smarty_tpl->getVariable('subordinateDisplay')->value;?>
</em><?php }?></td>
    </tr>
    <tr>
        <td class="content-label">&nbsp;</td>
        <td class="content-value">&nbsp;</td>
    </tr>
    <?php $_smarty_tpl->tpl_vars['phoneNumberWork'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPhoneNumberWork(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('phoneNumberWork',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('PHONE_WORK');?>
:</td>
        <td class="content-value"><?php echo $_smarty_tpl->getVariable('phoneNumberWork')->value;?>
</td>
    </tr>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['fte'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getFte(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('fte',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('EMPLOYMENT_PERCENTAGE');?>
:</td>
        <td class="content-value"><?php echo EmployeeFteConverter::display($_smarty_tpl->getVariable('fte')->value);?>
</td>
    </tr>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['employmentDate'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getEmploymentDate(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('employmentDate',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('EMPLOYMENT_DATE');?>
:</td>
        <td class="content-value"><?php echo DateConverter::display($_smarty_tpl->getVariable('employmentDate')->value);?>
</td>
    </tr>
    <?php }?>
    <?php $_smarty_tpl->tpl_vars['contractState'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getContractState(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('contractState',null,true,false)->value)){?>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('CONTRACT_STATE');?>
:</td>
        <td class="content-value"><?php echo EmployeeContractStateConverter::display($_smarty_tpl->getVariable('contractState')->value);?>
</td>
    </tr>
    <?php }?>
</table>
<!-- /employeeProfileOrganisationView.tpl -->