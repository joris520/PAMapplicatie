<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:41:06
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\report/assessmentProcessDashboardGroup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2144552406f22d0da82-59365155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbdda73b56d116fa0168839552745895da1b6d07' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\report/assessmentProcessDashboardGroup.tpl',
      1 => 1379954117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2144552406f22d0da82-59365155',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- assessmentProcessDashboardGroup.tpl -->
<br/>
<table class="dashboard" cellspacing="0" cellpadding="0" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <tr>
        <th class="alternate">&nbsp;</th>
        <th style="width:100px;">&nbsp;</th>
        <th class="seperator" style="width:20px;">&nbsp;</th>
        <th class="alternate last" colspan="13"><?php echo TXT_LC('DASHBOARD_PROGRESS');?>
</th>
    </tr>
    <tr>
        <th class="alternate">&nbsp;</th>
        <th>&nbsp;</th>
        <th class="seperator">&nbsp;</th>
        <th class="alternate" style="width:70px;"><em><?php echo TXT_LC('DASHBOARD_PHASE1');?>
</em></th>
        <th style="width:70px;"><em><?php echo TXT_LC('DASHBOARD_PHASE2');?>
</em></th>
        <th class="alternate"style="width:70px;"><em><?php echo TXT_LC('DASHBOARD_PHASE3');?>
</em></th>
        <th class="seperator" style="width:20px;">&nbsp;</th>
        <th class="alternate" colspan="3"><em><?php echo TXT_LC('DASHBOARD_PHASE3_EVALUATIONS');?>
</em></th>
    </tr>
    <tr>
        <th class="last alternate"><?php echo TXT_LC('MANAGER');?>
</th>
        <th class="last"><?php echo TXT_LC('INVITED');?>
</th>
        <th class="seperator">&nbsp;</th>
        <th class="alternate last" title="<?php echo TXT_UCF('DASHBOARD_PHASE1_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE1_LABEL');?>
</th>
        <th class="last" title="<?php echo TXT_UCF('DASHBOARD_PHASE2_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE2_LABEL');?>
</th>
        <th class="alternate last" title="<?php echo TXT_UCF('DASHBOARD_PHASE3_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE3_LABEL');?>
</th>
        <th class="seperator">&nbsp;</th>
        <th style="width:70px;" class="last alternate" title="<?php echo TXT_UCF('DASHBOARD_PHASE3_NO_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE3_NO_LABEL');?>
</th>
        <th style="width:70px;" class="last alternate" title="<?php echo TXT_UCF('DASHBOARD_PHASE3_PLANNED_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE3_PLANNED_LABEL');?>
</th>
        <th style="width:70px;" class="last alternate" title="<?php echo TXT_UCF('DASHBOARD_PHASE3_READY_DESCRIPTION');?>
"><?php echo TXT_LC('DASHBOARD_PHASE3_READY_LABEL');?>
</th>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->getCount()>0){?>
    <?php  $_smarty_tpl->tpl_vars['viewObject'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('interfaceObject')->value->getInterfaceObjects(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['viewObject']->key => $_smarty_tpl->tpl_vars['viewObject']->value){
?>
        <?php echo $_smarty_tpl->getVariable('viewObject')->value->fetchHtml();?>

    <?php }} ?>
    <tr>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="last">&nbsp;</td>
        <td class="last alternate">&nbsp;</td>
        <td class="seperator">&nbsp;</td>
        <td class="last alternate" colspan="3">&nbsp;</td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showTotals()){?>
    <tr style="text-align:center; font-weight:bold;" id="detail_dashboard_totals" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="last alternate">
            <?php echo TXT_UC('DASHBOARD_TOTALS');?>

        </td>
        <td class="last icon-link">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getInvitedTotal();?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getInvitedDetailLink();?>
</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        <td class="last icon-link alternate">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseInvitedTotal();?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseInvitedDetailLink();?>
</span>
        </td>
        <td class="last icon-link">
           <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseSelectEvaluationTotal();?>

           &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseSelectEvaluationLink();?>
</span>
        </td>
        <td class="last icon-link alternate">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseEvaluationTotal();?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseEvaluationLink();?>
</span>
        </td>
        <td class="last seperator">&nbsp;</td>
        <td class="last icon-link alternate">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationNotRequestedTotal();?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationNotRequestedDetailLink();?>
</span>
        </td>
        <td class="last icon-link alternate row-not-completed">
            <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationPlannedTotal();?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationPlannedDetailLink();?>

        </td>
        <td class="last icon-link alternate row-completed">
            <?php echo NumberConverter::display($_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationDoneTotal()+$_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationDoneNotRequestedTotal()+$_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationCancelledTotal());?>

            &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationReadyDetailLink();?>
</span>
        </td>
    </tr>
    <?php }?>
    <?php }else{ ?>
    <tr>
        <td class="last" colspan="100%"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->displayEmptyMessage();?>
</td>
    </tr>
    <?php }?>
</table>
<br />
<!-- /assessmentProcessDashboardGroup.tpl -->