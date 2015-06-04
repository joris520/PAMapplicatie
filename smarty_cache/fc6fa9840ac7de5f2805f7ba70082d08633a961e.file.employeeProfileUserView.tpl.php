<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:43:38
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\employee/profile/employeeProfileUserView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2992055701dca2158f7-83026442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc6fa9840ac7de5f2805f7ba70082d08633a961e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\employee/profile/employeeProfileUserView.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2992055701dca2158f7-83026442',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeProfileUserView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['styleLabelWidth'] = new Smarty_variable('style="width:220px;"', null, null);?>
<table class="content-table employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasUser()){?>
    <tr>
        <td class="content-label" <?php echo $_smarty_tpl->getVariable('styleLabelWidth')->value;?>
><?php echo TXT_UCF('USERNAME');?>
:</td>
        <td class="content-value"><span<?php if (!$_smarty_tpl->getVariable('valueObject')->value->isActive()){?> class="inactive" title="<?php echo TXT_UCF('DEACTIVATED_USER');?>
"<?php }?>><?php echo $_smarty_tpl->getVariable('valueObject')->value->getLogin();?>
</span><?php if (!$_smarty_tpl->getVariable('valueObject')->value->isActive()){?>&nbsp;<em><?php echo TXT_UCF('DEACTIVATED_USER');?>
</em><?php }?></td>
    </tr>
    <tr>
        <td class="content-label"><?php echo TXT_UCF('SECURITY');?>
:</td>
        <td class="content-value"><?php echo UserLevelConverter::display($_smarty_tpl->getVariable('valueObject')->value->getUserLevel());?>
</td>
    </tr>
    <?php }else{ ?>
    <tr>
        <td colspan="2" class="content-label info-text"><?php echo TXT_UCF('NO_EMPLOYEE_USER_LINK');?>
.</td>
    </tr>
    <?php }?>
</table>
<!-- /employeeProfileUserView.tpl -->