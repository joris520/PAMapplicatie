<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:40:03
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\list/resultViewDetail/assessmentProcess/employeeResultSelfAssessmentProcessView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:931352406ee3bad706-90915374%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6138684a0691d1bfb4a4c0a27ea7a8a2c79358e9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\list/resultViewDetail/assessmentProcess/employeeResultSelfAssessmentProcessView.tpl',
      1 => 1379954117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '931352406ee3bad706-90915374',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeResultSelfAssessmentProcessView.tpl -->
        <!-- states: <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getStatesInfo();?>
 -->
        <td class="dashed_line">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getManagerIconView()->fetchHtml();?>

        </td>
        <td class="dashed_line">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEmployeeIconView()->fetchHtml();?>

        </td>
<!-- /employeeResultSelfAssessmentProcessView.tpl -->