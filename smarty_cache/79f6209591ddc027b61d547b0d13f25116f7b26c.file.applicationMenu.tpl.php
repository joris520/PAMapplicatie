<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:10
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/application/interface/templates\navigation/applicationMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22259557013d648b8a7-99622295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79f6209591ddc027b61d547b0d13f25116f7b26c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/application/interface/templates\\navigation/applicationMenu.tpl',
      1 => 1433407462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22259557013d648b8a7-99622295',
  'function' => 
  array (
    'writeName' => 
    array (
      'parameter' => 
      array (
        'labelName' => '',
        'menuName' => '',
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- applicationMenu.tpl -->
<?php if (!function_exists('smarty_template_function_writeName')) {
    function smarty_template_function_writeName($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['writeName']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?><span class="activated"><?php }?><?php echo TXT_UCW($_smarty_tpl->getVariable('labelName')->value);?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?></span><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<?php if ($_smarty_tpl->getVariable('showEmployees')->value){?><a href="" onclick="xajax_public_navigation_applicationMenu_employees();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'EMPLOYEES','menuName'=>'APPLICATION_MENU_EMPLOYEES'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showDashboard')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_dashboard();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'MENU_DASHBOARD','menuName'=>'APPLICATION_MENU_DASHBOARD'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showSelfAssessment')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_selfAssessment();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'SELF_ASSESSMENT','menuName'=>'APPLICATION_MENU_SELFASSESSMENT'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showOrganisation')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_organisation();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'ORGANISATION','menuName'=>'APPLICATION_MENU_ORGANISATION'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showReports')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_reports();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'REPORTS','menuName'=>'APPLICATION_MENU_REPORTS'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showLibraries')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_library();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'LIBRARIES','menuName'=>'APPLICATION_MENU_LIBRARIES'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showSettings')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_settings();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'SETTINGS','menuName'=>'APPLICATION_MENU_SETTINGS'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showHelp')->value){?>&nbsp;|&nbsp;<a href="" onclick="xajax_public_navigation_applicationMenu_help();return false;"><?php smarty_template_function_writeName($_smarty_tpl,array('labelName'=>'HELP','menuName'=>'APPLICATION_MENU_HELP'));?>
</a><?php }?><?php if ($_smarty_tpl->getVariable('showHome')->value||$_smarty_tpl->getVariable('showEmployees')->value||$_smarty_tpl->getVariable('showOrganisation')->value||$_smarty_tpl->getVariable('showReports')->value||$_smarty_tpl->getVariable('showLibraries')->value||$_smarty_tpl->getVariable('showSettings')->value||$_smarty_tpl->getVariable('showHelp')->value){?>&nbsp;&nbsp;<br /><?php }?><span style="color: #666; line-height:30px;"><span title="<?php echo TXT_UCF('USER_LEVEL');?>
: <?php echo $_smarty_tpl->getVariable('USER_LEVEL_NAME')->value;?>
"><?php if (!constant('APPLICATION_IS_PRODUCTION_ENVIRONMENT')){?><span class="clickable" onClick="toggleVisilibityById('environment_info'); return false;"><?php }?><strong><?php echo $_smarty_tpl->getVariable('USER')->value;?>
</strong><?php if (!constant('APPLICATION_IS_PRODUCTION_ENVIRONMENT')){?></span><?php }?></span><?php if (PamApplication::isAllowedSwitchUserLevel()){?><span title="<?php echo TXT_UCF('SWITCH_USER_LEVEL');?>
">&nbsp;&nbsp;[<span style="font-weight:normal; font-style:italic;"><a href="" onClick="xajax_public_application_toggleUserLevel();return false;"><?php echo $_smarty_tpl->getVariable('USER_LEVEL_NAME')->value;?>
&nbsp;<img src="<?php echo constant('ICON_EDIT');?>
"></a></span>]</span><?php }?>&nbsp;|&nbsp;<?php if ($_smarty_tpl->getVariable('showChangePassword')->value){?><a href="" title="<?php echo TXT_UCF('CHANGE_PASSWORD');?>
" onclick="xajax_public_application_changePassword();return false;">&nbsp;<?php echo TXT_UCW('APPLICATION_MENU_PASSWORD');?>
</a><?php }?>&nbsp;|&nbsp;<?php if ($_smarty_tpl->getVariable('showLogOut')->value){?><a href="" onclick="xajax_moduleLogin_logOut();return false;">&nbsp;<?php echo TXT_UCW('LOG_OUT');?>
</a><?php }?>&nbsp;&nbsp;</span><?php if (!constant('APPLICATION_IS_PRODUCTION_ENVIRONMENT')){?><div id="environment_info" style="width:100%; background-color:<?php echo constant('ENVIRONMENT_COLOR');?>
; padding: 3px 0px;"><?php if ($_smarty_tpl->getVariable('showReferenceDateEditor')->value){?><form id="<?php echo $_smarty_tpl->getVariable('editorFormName')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('editorFormName')->value;?>
"><?php echo $_smarty_tpl->getVariable('referenceDateEditor')->value;?>
<?php }?>&nbsp;>>&nbsp;<?php echo $_smarty_tpl->getVariable('COMPANY_NAME')->value;?>
&nbsp;<span style="font-weight:normal; font-style:italic;"><?php echo $_smarty_tpl->getVariable('USER_LEVEL_NAME')->value;?>
</span>&nbsp;-&nbsp;<?php echo constant('ENVIRONMENT_DETAIL');?>
 <<&nbsp;&nbsp;<?php if ($_smarty_tpl->getVariable('showReferenceDateEditor')->value){?></form><?php }?></div><?php }?>
<!-- /applicationMenu.tpl -->