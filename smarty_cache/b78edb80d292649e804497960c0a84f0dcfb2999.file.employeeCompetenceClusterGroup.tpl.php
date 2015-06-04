<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:35
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeCompetenceClusterGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2667053834a2fdad4e8-88772546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b78edb80d292649e804497960c0a84f0dcfb2999' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeCompetenceClusterGroup.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2667053834a2fdad4e8-88772546',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeCompetenceClusterGroup.tpl -->
    <tr>
        <td class="shaded_title-new" colspan="100%">
            <table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
                <td>
                    <h3 style="padding:0; margin:0;">
                        <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getClusterName();?>
&nbsp;
                        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasIncompleteScores()){?>
                        &nbsp;<span class="warning-text" title="<?php echo TXT_UCF('TITLE_INCOMPLETE_SCORES');?>
"><?php echo TXT_UCF('INCOMPLETE_SCORES');?>
&nbsp;</span>
                        <?php }?>
                    </h3>
                </td>
                <td style="width:200px;" class="actions">
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEditLink();?>

                </td>
            </table>
        </td>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['scoreInterfaceObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['scoreInterfaceObject']->key => $_smarty_tpl->tpl_vars['scoreInterfaceObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('scoreInterfaceObject')->value->fetchHtml();?>

    <?php }} ?>
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
<!-- /employeeCompetenceClusterGroup.tpl -->