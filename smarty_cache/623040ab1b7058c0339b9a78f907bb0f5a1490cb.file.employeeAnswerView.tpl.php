<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:36
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeAnswerView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:624553834a30217e99-72478013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '623040ab1b7058c0339b9a78f907bb0f5a1490cb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeAnswerView.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '624553834a30217e99-72478013',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeAnswerView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<tr id="answer_row_<?php echo $_smarty_tpl->getVariable('valueObject')->value->getId();?>
" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <th class="shaded_title-new" style="text-align:left;">
        <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmployeeQuestion();?>

    </th>
    <th class="shaded_title-new" style="text-align:right; width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionsWidth();?>
">
       <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionLinks();?>

    </th>
</tr>
<tr>
    <td style="padding-left: 20px;">
        <?php $_smarty_tpl->tpl_vars['answer'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getAnswer(), null, null);?>
        <?php if (!empty($_smarty_tpl->getVariable('answer',null,true,false)->value)){?>
        <div style="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
" ><?php echo nl2br($_smarty_tpl->getVariable('answer')->value);?>
</div</td>
        <?php }?>
</tr>
<tr>
    <td colspan="100%">&nbsp;</td>
</tr>
<!-- /employeeAnswerView.tpl -->