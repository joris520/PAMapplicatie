<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:45:23
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\employee/target/employeeTargetGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:812855701e33759122-55011725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aebf93afb4aaa08b49c4c50ef2573a5b5cee74e3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\employee/target/employeeTargetGroup.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '812855701e33759122-55011725',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeTargetGroup.tpl -->
<table class="content-table" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
<?php if (count($_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects())>0){?>
    <tr>
        <th class="bottom_line shaded_title" style="width:250px;">
            <?php echo TXT_UCF('TARGET');?>

        </th>
        <th class="bottom_line shaded_title" style="width:245px;">
            <?php echo TXT_UCF('KPI');?>

        </th>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isViewAllowedEvaluation()){?>
        <th class="bottom_line shaded_title" style="width:175px;">
            <?php echo TXT_UCF('TARGET_STATUS');?>

        </th>
        <?php }?>
        <th class="bottom_line shaded_title" style="width:100px;">
            <?php echo TXT_UCF('TARGET_END_DATE');?>

        </th>
        <th class="bottom_line shaded_title actions" style="width:75px;">
            &nbsp;
        </th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['viewInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['viewInterfaceObject']->key => $_smarty_tpl->tpl_vars['viewInterfaceObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('viewInterfaceObject')->value->fetchHtml();?>

    <?php }} ?>
<?php }else{ ?>
    <tr>
        <td colspan="100%"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmptyMessage();?>
</td>
    </tr>
<?php }?>
</table><!-- /employeeTargetGroup.tpl -->