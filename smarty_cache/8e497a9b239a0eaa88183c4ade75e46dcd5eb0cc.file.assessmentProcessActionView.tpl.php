<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:03
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\assessmentProcess/assessmentProcessActionView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:580852406ee384c8d4-00727871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e497a9b239a0eaa88183c4ade75e46dcd5eb0cc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\assessmentProcess/assessmentProcessActionView.tpl',
      1 => 1379954115,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '580852406ee384c8d4-00727871',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- assessmentProcessActionView.tpl -->
<p><?php echo TXT_UCF('ACTIONS');?>
</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
">
    <tr>
        <td>
            <div id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getReplaceHtmlId();?>
">
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getActionHtml();?>

            </div>
        </td>
    </tr>
</table>
<hr />
<!-- /assessmentProcessActionView.tpl -->