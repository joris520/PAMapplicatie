<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:36
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeAnswerGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3209253834a301c0a04-60270716%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7d4f3f7c30bf424b981f0164e6e5157da250066' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeAnswerGroup.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3209253834a301c0a04-60270716',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeAnswerGroup.tpl -->
<?php if (count($_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects())>0){?>
    <table  class="content-table employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
        <?php  $_smarty_tpl->tpl_vars['answerInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['answerInterfaceObject']->key => $_smarty_tpl->tpl_vars['answerInterfaceObject']->value){
?>
            <?php echo $_smarty_tpl->getVariable('answerInterfaceObject')->value->fetchHtml();?>

        <?php }} ?>
        <tr>
            <td></td>
        </tr>
    </table>
<?php }?>
<!-- /employeeAnswerGroup.tpl -->