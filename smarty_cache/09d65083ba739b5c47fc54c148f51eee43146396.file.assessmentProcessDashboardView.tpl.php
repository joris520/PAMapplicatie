<?php /* Smarty version Smarty-3.0.7, created on 2013-09-23 18:41:06
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\report/assessmentProcessDashboardView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2485852406f22e62760-15384666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09d65083ba739b5c47fc54c148f51eee43146396' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\report/assessmentProcessDashboardView.tpl',
      1 => 1379954117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2485852406f22e62760-15384666',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- assessmentProcessDashboardView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<tr style="text-align:center;" id="detail_dashboard_<?php echo $_smarty_tpl->getVariable('valueObject')->value->getBossId();?>
" onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
    <td class="alternate" style="text-align:left;">
        <?php echo NameConverter::display($_smarty_tpl->getVariable('valueObject')->value->getBossName());?>

    </td>
    <td class="icon-link">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getInvitedTotal());?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getInvitedDetailLink();?>
</span>
    </td>
    <td class="seperator">&nbsp;</td>
    <?php $_smarty_tpl->tpl_vars['phaseInvited'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPhaseInvited(), null, null);?>
    <td class="alternate icon-link<?php if ($_smarty_tpl->getVariable('phaseInvited')->value>0){?> row-current<?php }?>">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('phaseInvited')->value);?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseInvitedDetailLink();?>

    </td>
    <?php $_smarty_tpl->tpl_vars['phaseSelectEvaluation'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPhaseSelectEvaluation(), null, null);?>
    <td class="icon-link<?php if ($_smarty_tpl->getVariable('phaseSelectEvaluation')->value>0){?> row-current<?php }?>">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('phaseSelectEvaluation')->value);?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseSelectEvaluationLink();?>

    </td>
    <?php $_smarty_tpl->tpl_vars['phaseEvaluation'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getPhaseEvaluation(), null, null);?>
    <td class="alternate icon-link<?php if ($_smarty_tpl->getVariable('phaseEvaluation')->value>0){?> row-current<?php }?>">
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('phaseEvaluation')->value);?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPhaseEvaluationLink();?>

    </td>
    <?php if ($_smarty_tpl->getVariable('phaseEvaluation')->value>0){?>
        <?php $_smarty_tpl->tpl_vars['evaluationNoneAttributes'] = new Smarty_variable('class="alternate icon-link"', null, null);?>
        <?php $_smarty_tpl->tpl_vars['evaluationPlannedAttributes'] = new Smarty_variable('class="alternate icon-link row-not-completed"', null, null);?>
        <?php $_smarty_tpl->tpl_vars['evaluationDoneAttributes'] = new Smarty_variable('class="alternate icon-link row-completed"', null, null);?>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['evaluationNoneAttributes'] = new Smarty_variable('class="icon-link"', null, null);?>
        <?php $_smarty_tpl->tpl_vars['evaluationPlannedAttributes'] = new Smarty_variable('class="icon-link"', null, null);?>
        <?php if ($_smarty_tpl->getVariable('valueObject')->value->getEvaluationDoneNotRequested()>0){?>
        <?php $_smarty_tpl->tpl_vars['evaluationDoneAttributes'] = new Smarty_variable('class="icon-link row-done-not-requested"', null, null);?>
        <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['evaluationDoneAttributes'] = new Smarty_variable('class="icon-link"', null, null);?>
        <?php }?>
    <?php }?>
    <td class="seperator">&nbsp;</td>
    <td <?php echo $_smarty_tpl->getVariable('evaluationNoneAttributes')->value;?>
>
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEvaluationNotRequested());?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationNotRequestedDetailLink();?>

    </td>
    <td <?php echo $_smarty_tpl->getVariable('evaluationPlannedAttributes')->value;?>
>
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEvaluationPlanned());?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationPlannedDetailLink();?>

    </td>
    <td <?php echo $_smarty_tpl->getVariable('evaluationDoneAttributes')->value;?>
>
        <?php echo NumberConverter::display($_smarty_tpl->getVariable('valueObject')->value->getEvaluationDone()+$_smarty_tpl->getVariable('valueObject')->value->getEvaluationDoneNotRequested()+$_smarty_tpl->getVariable('valueObject')->value->getEvaluationCancelled());?>

        &nbsp;<span class="activeRow icon-style"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getEvaluationReadyDetailLink();?>

    </td>
</tr>
<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showDebug()){?>
<tr>
    <td colspan="100%">
        <pre><?php echo print_r($_smarty_tpl->getVariable('valueObject')->value,true);?>
</pre>
    </td>
</tr>
<?php }?>
<!-- /assessmentProcessDashboardView.tpl -->