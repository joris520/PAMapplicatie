<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:08
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\navigation/applicationMenuCustomers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2747752406ee8e43891-24305568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8fcf2db969b898c71cc3ef315b1b31c6a790cf47' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\navigation/applicationMenuCustomers.tpl',
      1 => 1379954112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2747752406ee8e43891-24305568',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- adminMenu.tpl -->
<a href="" onclick="xajax_moduleCustomers_displayCustomers();return false;"><span class="activated">Klantbeheer</span></a>&nbsp;|&nbsp;<a href="" onclick="xajax_moduleLogin_logOut();return false;">Uitloggen</a>&nbsp;&nbsp;<br /><span style="color: #666; line-height:30px;"><span><strong><?php echo $_smarty_tpl->getVariable('USER')->value;?>
</strong>&nbsp;[<span style="font-weight:normal;font-style:italic;"><?php echo $_smarty_tpl->getVariable('USER_LEVEL_NAME')->value;?>
</span>]</span>&nbsp;&nbsp;</span><?php if (!constant('APPLICATION_IS_PRODUCTION_ENVIRONMENT')){?><div style="width:100%; background-color:<?php echo constant('ENVIRONMENT_COLOR');?>
; padding:3px;">Omgeving: >> <?php echo constant('ENVIRONMENT_DETAIL');?>
 << &nbsp;&nbsp;</div><?php }?>

<!-- /adminMenu.tpl -->