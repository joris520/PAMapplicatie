<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:18:56
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\navigation/dashboardMenuPam4.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31858556ffbe0a21570-96906784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d8a2c01c7afa485bfb34aa98452c982ea4be3f0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\navigation/dashboardMenuPam4.tpl',
      1 => 1433243548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31858556ffbe0a21570-96906784',
  'function' => 
  array (
    'activeClass' => 
    array (
      'parameter' => 
      array (
        'menuName' => '',
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- dashboardMenuPam4.tpl -->
<?php if (!function_exists('smarty_template_function_activeClass')) {
    function smarty_template_function_activeClass($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['activeClass']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?>active-menu-item<?php }?><?php if ($_smarty_tpl->getVariable('lastModule')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?> last<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        <?php if ($_smarty_tpl->getVariable('showDepartments')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DEPARTMENTS'));?>
"
                onclick="xajax_public_dashboard__displayDepartments();return false;">
                <a href=""><?php echo TXT_TAB('DEPARTMENTS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showManagers')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_MANAGERS'));?>
"
                onclick="xajax_public_dashboard__displayManagers();return false;">
                <a href=""><?php echo TXT_TAB('REPORT_MANAGERS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardPdpActions')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS'));?>
"
                onclick="xajax_public_dashboard__displayPdpActionDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_PDP_ACTIONS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardTargets')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS'));?>
"
                onclick="xajax_public_dashboard__displayTargetDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_PREFIX');?>
&nbsp;<?php echo TXT_TAB(constant('CUSTOMER_TARGETS_TAB_LABEL'));?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardFinalResult')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT'));?>
"
                onclick="xajax_public_dashboard__displayFinalResultDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_FINAL_RESULT');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardTraining')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING'));?>
"
                onclick="xajax_public_dashboard__displayTrainingDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_TRAINING');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showOverviewSelfAssessmentInvitations')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS'));?>
"
                onclick="xajax_public_dashboard__displayInvitations();return false;">
                <a href=""><?php echo TXT_TAB('MENU_REPORT_SELFASSESSMENT_INVITATIONS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardSelfAssessments')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS'));?>
"
                onclick="xajax_public_dashboard__displayInvitationDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_ASSESSMENT_COMPLETED');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showDashboardAssessmentProcess')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS'));?>
"
                onclick="xajax_public_dashboard__displayProcessDashboard();return false;">
                <a href=""><?php echo TXT_TAB('MENU_DASHBOARD_ASSESSMENT_PROCESS');?>
</a>
            </td>
        <?php }?>
        </tr>
    </table>
</div>
<!-- /dashboardMenuPam4.tpl -->
