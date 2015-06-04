<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 09:30:44
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\list/employeeFilterDetail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24458556ffea408d3f3-33716251%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06771b5595dbea8aba07351b521cdca5e2f88e03' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\list/employeeFilterDetail.tpl',
      1 => 1433243584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24458556ffea408d3f3-33716251',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeFilterDetail.tpl -->
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showBossFilter()||$_smarty_tpl->getVariable('interfaceObject')->value->showDepartmentFilter()||$_smarty_tpl->getVariable('interfaceObject')->value->showBossFilter()||$_smarty_tpl->getVariable('interfaceObject')->value->showAssessmentFilter()){?>
    <table border="0" cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showBossFilter()){?>
        <?php $_smarty_tpl->tpl_vars['bossIdValues'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getBossFilterIdValues(), null, null);?>
        <?php if (count($_smarty_tpl->getVariable('bossIdValues')->value)>1){?>
        <tr>
            <td>
                <select onchange="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
" id="filter_boss" name="filter_boss">
                    <?php $_template = new Smarty_Internal_Template('components/selectIdValuesComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('idValues',$_smarty_tpl->getVariable('bossIdValues')->value);$_template->assign('currentValue',$_smarty_tpl->getVariable('interfaceObject')->value->getSelectedBossFilterValue());$_template->assign('required',false);$_template->assign('subject',TXT_LC('BOSS')); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
            </td>
        </tr>
        <?php }?>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showDepartmentFilter()){?>
        <?php $_smarty_tpl->tpl_vars['departmentIdValues'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getDepartmentFilterIdValues(), null, null);?>
        <?php if (count($_smarty_tpl->getVariable('departmentIdValues')->value)>0){?>
        <tr>
            <td>
                <select onchange="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
" id="filter_department" name="filter_department">
                    <?php $_template = new Smarty_Internal_Template('components/selectIdValuesComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('idValues',$_smarty_tpl->getVariable('departmentIdValues')->value);$_template->assign('currentValue',$_smarty_tpl->getVariable('interfaceObject')->value->getSelectedDepartmentFilterValue());$_template->assign('required',false);$_template->assign('subject',TXT_LC('DEPARTMENT')); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
            </td>
        </tr>
        <?php }?>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showFunctionFilter()){?>
        <?php $_smarty_tpl->tpl_vars['functionIdValues'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getFunctionFilterIdValues(), null, null);?>
        <?php if (count($_smarty_tpl->getVariable('functionIdValues')->value)>0){?>
        <tr>
            <td>
                <select onchange="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
" id="filter_function" name="filter_function">
                    <?php $_template = new Smarty_Internal_Template('components/selectIdValuesComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('idValues',$_smarty_tpl->getVariable('functionIdValues')->value);$_template->assign('currentValue',$_smarty_tpl->getVariable('interfaceObject')->value->getSelectedFunctionFilterValue());$_template->assign('required',false);$_template->assign('subject',TXT_LC('FUNCTION')); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
            </td>
        </tr>
        <?php }?>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showAssessmentFilter()){?>
        <tr>
            <td>
                <select onchange="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
" id="filter_assessment" name="filter_assessment">
                <?php $_template = new Smarty_Internal_Template('components/selectOptionsComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('values',EmployeeAssessmentFilterValue::values(EmployeeAssessmentFilterValue::MODE_EMPLOYEELIST));$_template->assign('currentValue',$_smarty_tpl->getVariable('interfaceObject')->value->getSelectedAssessmentFilterValue());$_template->assign('required',false);$_template->assign('subject',TXT_LC('STATUS'));$_template->assign('converter','EmployeeAssessmentFilterConverter'); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
            </td>
        </tr>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showSortFilter()){?>
        <tr>
            <td>
                <select onchange="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->submitFunction();?>
" id="filter_sort" name="filter_sort">
                <?php $_template = new Smarty_Internal_Template('components/selectOptionsComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('values',EmployeeSortFilterValue::values());$_template->assign('currentValue',$_smarty_tpl->getVariable('interfaceObject')->value->getSelectedSortFilterValue());$_template->assign('required',true);$_template->assign('converter','EmployeeSortFilterConverter'); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
            </td>
        </tr>
    <?php }?>
    </table>
<?php }?>
<!-- /employeeFilterDetail.tpl -->