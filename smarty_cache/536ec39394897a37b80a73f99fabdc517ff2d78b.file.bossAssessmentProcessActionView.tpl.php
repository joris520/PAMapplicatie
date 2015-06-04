<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:03
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\assessmentProcess/bossAssessmentProcessActionView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1750652406ee37a9e36-08968729%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '536ec39394897a37b80a73f99fabdc517ff2d78b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\assessmentProcess/bossAssessmentProcessActionView.tpl',
      1 => 1379954115,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1750652406ee37a9e36-08968729',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- bossAssessmentProcessActionView.tpl -->
<table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
">
    <?php $_smarty_tpl->tpl_vars['actionMessage'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getActionMessage(), null, null);?>
    <?php if (!empty($_smarty_tpl->getVariable('actionMessage',null,true,false)->value)){?>
    <tr>
        <td>
            <em><?php echo $_smarty_tpl->getVariable('actionMessage')->value;?>
</em>
            &nbsp;<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getUndo();?>

        </td>
    </tr>
    <?php }?>
    <tr>
        <td>
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getAction();?>

        </td>
    </tr>
</table>
<!-- /bossAssessmentProcessActionView.tpl -->