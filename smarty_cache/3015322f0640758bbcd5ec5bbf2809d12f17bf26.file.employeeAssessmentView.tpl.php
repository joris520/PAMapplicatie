<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:35
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeAssessmentView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2853153834a2fb95f89-74885136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3015322f0640758bbcd5ec5bbf2809d12f17bf26' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeAssessmentView.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2853153834a2fb95f89-74885136',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeAssessmentView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<table  class="content-table employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
    <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasAssessment()){?>
    <tr>
        <td class="content-label"  style="width:150px;">
            <?php echo TXT_UCF('CONVERSATION_DATE');?>
:
        </td>
        <td class="content-value">
            <?php echo DateConverter::display($_smarty_tpl->getVariable('valueObject')->value->getAssessmentDate(),TXT_UCF('NO_ASSESSMENT_DATE'));?>

        </td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isViewAllowedScoreStatus()){?>
    <tr>
        <td class="content-label">
            <?php echo TXT_UCF('SCORE_STATUS');?>
:
        </td>
        <td class="content-value">
            <?php echo ScoreStatusConverter::display($_smarty_tpl->getVariable('valueObject')->value->getScoreStatus());?>

        </td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showAssessmentNote()){?>
        <?php $_smarty_tpl->tpl_vars['assessmentNote'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getAssessmentNote(), null, null);?>
        <?php if (!empty($_smarty_tpl->getVariable('assessmentNote',null,true,false)->value)){?>
        <tr>
            <td class="content-label">
                <?php echo TXT_UCF('REMARKS');?>
:
            </td>
            <td class="content-value">
                <?php echo nl2br($_smarty_tpl->getVariable('assessmentNote')->value);?>

            </td>
        </tr>
        <?php }?>
    <?php }?>
    <?php }?>
    <?php }else{ ?>
    <tr>
        <td class="content-label"  style="width:150px;">
            <?php echo TXT_UCF('ASSESSMENT');?>
:
        </td>
        <td class="content-value">
            <?php echo TXT_UCF('NO_ASSESSMENT_DONE');?>

        </td>
    </tr>
    <?php }?>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showSelfAssessment()){?>
    <tr>
        <td class="content-label" style="width:150px;">
            <?php echo TXT_UCF('SELF_ASSESSMENT');?>
:
        </td>
        <td class="content-value">
            <?php echo SelfAssessmentInvitationStateConverter::display($_smarty_tpl->getVariable('interfaceObject')->value->getSelfAssessmentState());?>

            <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showCompletedStatus()){?>
            <?php echo AssessmentInvitationCompletedConverter::image($_smarty_tpl->getVariable('interfaceObject')->value->getCompletedStatus());?>

            <?php echo AssessmentInvitationCompletedConverter::displayReport($_smarty_tpl->getVariable('interfaceObject')->value->getCompletedStatus());?>

            <?php }?>
        </td>
    </tr>
    <?php }?>
</table>
<!-- /employeeAssessmentView.tpl -->