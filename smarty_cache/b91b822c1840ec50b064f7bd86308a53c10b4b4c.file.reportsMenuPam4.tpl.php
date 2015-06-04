<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:19:16
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/application/interface/templates\navigation/reportsMenuPam4.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23673556ffbf482c029-00089247%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b91b822c1840ec50b064f7bd86308a53c10b4b4c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/application/interface/templates\\navigation/reportsMenuPam4.tpl',
      1 => 1433243548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23673556ffbf482c029-00089247',
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
<!-- reportsMenuPam4.tpl -->
<?php if (!function_exists('smarty_template_function_activeClass')) {
    function smarty_template_function_activeClass($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['activeClass']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?>active-menu-item<?php }?><?php if ($_smarty_tpl->getVariable('lastModule')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?> last<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="application-content block-menu" style="margin-left: auto; margin-right:auto;">
    <table class="tab-menu">
        <tr>
        <?php if ($_smarty_tpl->getVariable('showSelfAssessmentReports')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_SELFASSESSMENT_REPORTS'));?>
"
                onclick="xajax_moduleOrganisation_selfassessmentReportsForm();return false;">
                <a href=""><?php echo TXT_TAB('SELFASSESSMENT_REPORTS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showScoreboard')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_SCOREBOARD'));?>
"
                onclick="xajax_moduleScoreboard_calc(0);return false;">
                <a href=""><?php echo TXT_TAB('SCOREBOARD');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showTalentSelector')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_TALENT_SELECTOR'));?>
"
                onclick="xajax_public_report__displayTalentSelector();return false;">
                <a href=""><?php echo TXT_TAB('TALENT_SELECTOR');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPerformanceGrid')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_PERFORMANCE_GRID'));?>
"
                onclick="xajax_modulePerformanceGrid_displayPerformanceGrid();return false;">
                <a href=""><?php echo TXT_TAB('PERFORMANCE_GRID');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPrintPortfolio')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_PORTFOLIO'));?>
"
                onclick="xajax_moduleEmployeesPrints_printEmployeesFullPortfolio_deprecated();return false;">
                <a href=""><?php echo TXT_TAB('EMPLOYEES');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showHistory')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_HISTORY'));?>
"
                onclick="xajax_moduleHistory_menu();return false;">
                <a href=""><?php echo TXT_TAB('TAB_HISTORY');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showManagers')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_REPORTS_MANAGER'));?>
"
                onclick="xajax_public_report__displayManagers();return false;">
                <a href=""><?php echo TXT_TAB('REPORT_MANAGERS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('show360')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_360'));?>
"
                onclick="xajax_module360_display360Employees();return false;">
                <a href=""><?php if (constant('CUSTOMER_OPTION_USE_SELFASSESSMENT')){?><?php echo TXT_TAB('REPORT_MENU_SELF_ASSESSMENT');?>
<?php }else{ ?>360&deg;<?php }?></a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showPdpTodoList')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_PDP_TODO_LIST'));?>
"
                onclick="xajax_modulePDPToDoList();return false;">
                <a href=""><?php echo TXT_TAB('PDP_TODO_LIST');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showNotificationAlerts')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMAIL_PDP_NOTIFICATION_ALERTS'));?>
"
                onclick="xajax_moduleEmails_showPDPActionsNotificationAlerts();return false;">
                <a href=""><strong><?php echo TXT_TAB('PDP_NOTIFICATION_MESSAGE_ALERTS');?>
</strong></a>
            </td>
        <?php }?>
        </tr>
    </table>
</div>
<!-- /reportsMenuPam4.tpl -->