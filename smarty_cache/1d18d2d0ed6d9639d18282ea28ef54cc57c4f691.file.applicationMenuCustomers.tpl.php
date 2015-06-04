<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:22:30
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/application/interface/templates\navigation/applicationMenuCustomers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16502557018d6dea155-39546680%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d18d2d0ed6d9639d18282ea28ef54cc57c4f691' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/application/interface/templates\\navigation/applicationMenuCustomers.tpl',
      1 => 1433407462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16502557018d6dea155-39546680',
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