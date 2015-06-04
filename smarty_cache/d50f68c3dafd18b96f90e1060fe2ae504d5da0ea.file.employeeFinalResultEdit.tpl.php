<?php /* Smarty version Smarty-3.0.7, created on 2014-05-27 15:48:50
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/finalResult/employeeFinalResultEdit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17088538497c20fde74-52689454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd50f68c3dafd18b96f90e1060fe2ae504d5da0ea' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/finalResult/employeeFinalResultEdit.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17088538497c20fde74-52689454',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeFinalResultEdit.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['totalScoreEditType'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getTotalScoreEditType(), null, null);?>
<span id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNotesHtmlId();?>
">
    <table cellspacing="0" cellpadding="2" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
">
        </tr>
            <th class="form-label" style="width:150px;">
                <label for="assessment_date"><?php echo TXT_UCW('CONVERSATION_DATE');?>
 <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getRequiredFieldIndicator();?>
</label>
            </th>
            <td class="form-value" style="width:650px;">
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getAssessmentDatePicker();?>

            </td>
            <td class="actions"    style="width:50px;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr style="text-align: left">
            <th class="shaded_title"  colspan="2">
                <?php echo TXT_UCW('FINAL_RESULT');?>

            </th>
            <th class="shaded_title actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNotesVisibilityLink();?>

                <?php }else{ ?>
                    &nbsp;
                <?php }?>
            </th>
        </tr>
        <tr>
            <td class="form-label"><?php echo TXT_UCF('TOTAL_RESULT');?>
 <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getRequiredFieldIndicator();?>
</td>
            <td class="form-value">
                <?php if ($_smarty_tpl->getVariable('totalScoreEditType')->value==TotalScoreEditType::SELECT_LIST){?>
                <?php $_smarty_tpl->tpl_vars['totalScores'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getTotalScoreIdValues(), null, null);?>
                <select id="total_score" name="total_score">
                    <?php $_template = new Smarty_Internal_Template('components/selectIdValuesComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('idValues',$_smarty_tpl->getVariable('totalScores')->value);$_template->assign('currentValue',$_smarty_tpl->getVariable('valueObject')->value->getTotalScore());$_template->assign('required',true);$_template->assign('subject',TXT_LC('FINAL_RESULT')); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                </select>
                <?php }elseif($_smarty_tpl->getVariable('totalScoreEditType')->value==TotalScoreEditType::RADIO_BUTTONS){?>
                <?php $_template = new Smarty_Internal_Template('components/finalResultEditComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('scaleType',ScaleValue::SCALE_1_5);$_template->assign('inputName','total_score');$_template->assign('isEmptyAllowed',false);$_template->assign('score',$_smarty_tpl->getVariable('valueObject')->value->getTotalScore()); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                <?php }?>
            </td>
            <td class="actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::TOTAL_NOTE_NAME);?>

                <?php }?>
            </td>
        </tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <tr id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultEdit::TOTAL_NOTE_NAME);?>
" class="comment-row" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?>style="display:none;"<?php }?>>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="total_score_comment" name="total_score_comment" style="height:100px; width:690px"><?php echo $_smarty_tpl->getVariable('valueObject')->value->getTotalScoreComment();?>
</textarea>
            </td>
        </tr>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showDetailScores()){?>
        <tr>
            <td class="form-label" style="padding-left: 30px"><?php echo TXT_UCF('BEHAVIOUR');?>
 <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getRequiredFieldIndicator();?>
</td>
            <td class="form-value">
                <?php $_template = new Smarty_Internal_Template('components/scoreEditComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('scaleType',ScaleValue::SCALE_1_5);$_template->assign('inputName','behaviour_score');$_template->assign('isEmptyAllowed',false);$_template->assign('score',$_smarty_tpl->getVariable('valueObject')->value->getBehaviourScore()); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            </td>
            <td class="actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME);?>

                <?php }?>
            </td>
        </tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <tr id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultEdit::BEHAVIOUR_NOTE_NAME);?>
" class="comment-row" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?>style="display:none;"<?php }?>>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="behaviour_score_comment" name="behaviour_score_comment" style="height:100px; width:690px"><?php echo $_smarty_tpl->getVariable('valueObject')->value->getBehaviourScoreComment();?>
</textarea>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td class="form-label" style="padding-left: 30px"><?php echo TXT_UCF('RESULTS');?>
 <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getRequiredFieldIndicator();?>
</td>
            <td class="form-value">
                <?php $_template = new Smarty_Internal_Template('components/scoreEditComponent.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('scaleType',ScaleValue::SCALE_1_5);$_template->assign('inputName','results_score');$_template->assign('isEmptyAllowed',false);$_template->assign('score',$_smarty_tpl->getVariable('valueObject')->value->getResultsScore()); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            </td>
            <td class="actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultEdit::RESULTS_NOTE_NAME);?>

                <?php }?>
            </td>
        </tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <tr id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultEdit::RESULTS_NOTE_NAME);?>
" class="comment-row" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?>style="display:none;"<?php }?>>
            <td class="form_value" colspan="100%" style="padding-left:69px;">
                <textarea id="results_score_comment" name="results_score_comment" style="height:100px; width:690px"><?php echo $_smarty_tpl->getVariable('valueObject')->value->getResultsScoreComment();?>
</textarea>
            </td>
        </tr>
        <?php }?>
        <?php }?>
    </table>
</span>
<!-- /employeeFinalResultEdit.tpl -->