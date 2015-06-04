<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:01:12
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/application/interface/templates\navigation/employeesMenuPam4.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21704557013d8e11cd6-56218090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2689ea73e9aabf07d032f60f6283fcef7688525b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/application/interface/templates\\navigation/employeesMenuPam4.tpl',
      1 => 1433407463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21704557013d8e11cd6-56218090',
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
<!-- employeesMenuPam4.tpl -->
<?php if (!function_exists('smarty_template_function_activeClass')) {
    function smarty_template_function_activeClass($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['activeClass']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
<?php if ($_smarty_tpl->getVariable('active')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?>active-menu-item<?php }?><?php if ($_smarty_tpl->getVariable('lastModule')->value==constant($_smarty_tpl->getVariable('menuName')->value)){?> last<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

<div class="application-content block-menu">
    <?php if ($_smarty_tpl->getVariable('noEmployee')->value){?>
    <div class="tab-menu" style="padding:9px 15px;">
        <h2 style="margin:0px; padding:0px">&nbsp;<?php echo TXT_UCF('SELECT_EMPLOYEES');?>
</h2>
    </div>
    <?php }else{ ?>
    <table class="tab-menu">
        <tr>
        <?php if ($_smarty_tpl->getVariable('showEmployeeProfile')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_PROFILE'));?>
"
                onclick="xajax_public_employeeProfile__displayPage(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('EMPLOYEE_PROFILE');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeAttachments')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_ATTACHMENTS'));?>
"
                onclick="xajax_public_employeeDocument__displayPage(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('ATTACHMENTS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeScore')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_SCORE'));?>
"
                onclick="xajax_public_employeeCompetence__displayPage(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB(constant('CUSTOMER_SCORE_TAB_LABEL'));?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeePdpActions')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_PDP_ACTIONS'));?>
"
                onclick="xajax_public_employeePdpAction__displayPage(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('PDP_ACTIONS');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeTargets')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_TARGETS'));?>
"
                onclick="xajax_public_employeeTarget__displayEmployeeTargets(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href="" ><?php echo TXT_TAB(constant('CUSTOMER_TARGETS_TAB_LABEL'));?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeFinalResult')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_FINAL_RESULTS'));?>
"
                onclick="xajax_public_employeeFinalResult__displayFinalResult(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('FINAL_RESULT');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeTraining')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_TRAINING'));?>
"
                onclick="xajax_public_employeeTraining__displayTraining(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('TRAINING');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployee360')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_360'));?>
"
                onclick="xajax_moduleEmployees_360_menu_deprecated(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php if (constant('CUSTOMER_OPTION_USE_SELFASSESSMENT')){?><?php echo TXT_TAB('SELF_ASSESSMENT');?>
<?php }else{ ?>360&deg;<?php }?></a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeHistory')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_HISTORY'));?>
"
                onclick="xajax_moduleEmployees_history_menu_deprecated(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
, 'function');return false;">
                <a href=""><?php echo TXT_TAB('TAB_HISTORY');?>
</a>
            </td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('showEmployeeInvitations')->value){?>
            <td class="clickable <?php smarty_template_function_activeClass($_smarty_tpl,array('menuName'=>'MODULE_EMPLOYEE_INVITATIONS'));?>
"
                onclick="xajax_public_employeeAssessmentInvitation__displayPage(<?php echo $_smarty_tpl->getVariable('employeeId')->value;?>
);return false;">
                <a href=""><?php echo TXT_TAB('VIEW_INVITATIONS');?>
</a>
            </td>
        <?php }?>
        </tr>
    </table>
    <?php }?>
</div>
<!-- /employeesMenuPam4.tpl -->