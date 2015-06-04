<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 11:46:07
         compiled from "C:\xampp\htdocs\broodjesalami\php_cm/modules/interface/templates\employee/finalResult/employeeFinalResultView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:681555701e5fbab1f7-36994484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f86f6f7bc66964e78c4c8fe882b2be6f28b57839' => 
    array (
      0 => 'C:\\xampp\\htdocs\\broodjesalami\\php_cm/modules/interface/templates\\employee/finalResult/employeeFinalResultView.tpl',
      1 => 1433407469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '681555701e5fbab1f7-36994484',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeFinalResultView.tpl -->
<?php $_smarty_tpl->tpl_vars['valueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['assessmentCycleValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('valueObject')->value->getAssessmentCycleValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['previousValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getPreviousValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['previousAssessmentCycleValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('previousValueObject')->value->getAssessmentCycleValueObject(), null, null);?>
<?php $_smarty_tpl->tpl_vars['commentIndentation'] = new Smarty_variable('margin-left:200px', null, null);?>
<span id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNotesHtmlId();?>
">
    <p class="info-text">
        <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getInstructionText();?>

    </p>
    <br/>
    <table  class="content-table  employee" style="width:<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDisplayWidth();?>
;">
        </tr>
            <td class="form-label" style="width:200px;">
                <?php echo TXT_UCF('CONVERSATION_DATE');?>

            </td>
            <td class="form-value" colspan="3">
                <?php echo DateConverter::display($_smarty_tpl->getVariable('valueObject')->value->getAssessmentDate());?>

            </td>
        </tr>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr style="text-align: left">
            <th class="" style="width:200px;">
                &nbsp;
            </th>
            <th class="shaded_title centered previous-period-header" style="width:200px;">
                <?php echo $_smarty_tpl->getVariable('previousAssessmentCycleValueObject')->value->getAssessmentCycleName();?>

            </th>
            <th class="shaded_title centered current-period-header" style="width:200px;">
                <?php echo $_smarty_tpl->getVariable('assessmentCycleValueObject')->value->getAssessmentCycleName();?>

            </th>
            <th class="actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                    <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNotesVisibilityLink();?>

                <?php }else{ ?>
                    &nbsp;
                <?php }?>
            </th>
        </tr>
        <tr style="text-align: left">
            <th class="shaded_title"  colspan="100%">
                <?php echo TXT_UCW('FINAL_RESULT');?>

            </th>
        </tr>
        <tr>
            <th class="content-line">
                <?php echo TXT_UCF('TOTAL_RESULT');?>

            </th>
            <td class="content-line centered previous-period">
                <?php echo TotalScoreConverter::display($_smarty_tpl->getVariable('previousValueObject')->value->getTotalScore());?>

            </td>
            <td class="content-line centered current-period">
                <?php echo TotalScoreConverter::display($_smarty_tpl->getVariable('valueObject')->value->getTotalScore());?>

            </td>
            <td class="content-line actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasTotalScoreComment()||$_smarty_tpl->getVariable('previousValueObject')->value->hasTotalScoreComment()){?>
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultView::TOTAL_NOTE_NAME);?>

                <?php }?>
                <?php }?>
            </td>
        </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasTotalScoreComment()&&$_smarty_tpl->getVariable('previousValueObject')->value->hasTotalScoreComment()){?>
        <tr class="comment-row" id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultView::TOTAL_NOTE_NAME);?>
" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?> style="display:none;"<?php }?>>
            <td class="content-line" colspan="100%">
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasTotalScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('assessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('valueObject')->value->getTotalScoreComment());?>
</span>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('previousValueObject')->value->hasTotalScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('previousAssessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('previousValueObject')->value->getTotalScoreComment());?>
</span>
                </div>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        <?php }?>
    <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showDetailScores()){?>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr>
            <th class="content-line " style="padding-left: 30px;">
                <?php echo TXT_UCF('BEHAVIOUR');?>

            </th>
            <td class="content-line centered previous-period">
                <?php echo ScoreConverter::display($_smarty_tpl->getVariable('previousValueObject')->value->getBehaviourScore());?>

            </td>
            <td class="content-line centered current-period">
                <?php echo ScoreConverter::display($_smarty_tpl->getVariable('valueObject')->value->getBehaviourScore());?>

            </td>
            <td class="content-line actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasBehaviourScoreComment()||$_smarty_tpl->getVariable('previousValueObject')->value->hasBehaviourScoreComment()){?>
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME);?>

                <?php }?>
                <?php }?>
            </td>
        </tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasBehaviourScoreComment()||$_smarty_tpl->getVariable('previousValueObject')->value->hasBehaviourScoreComment()){?>
        <tr class="comment-row" id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultView::BEHAVIOUR_NOTE_NAME);?>
" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?> style="display:none;"<?php }?>>
            <td class="content-line" colspan="100%" >
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasBehaviourScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('assessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('valueObject')->value->getBehaviourScoreComment());?>
</span>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('previousValueObject')->value->hasBehaviourScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('previousAssessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('previousValueObject')->value->getBehaviourScoreComment());?>
</span>
                </div>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        <?php }?>
        <?php }?>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
        <tr>
            <th class="content-line" style="padding-left: 30px;">
                <?php echo TXT_UCF('RESULTS');?>

            </th>
            <td class="content-line centered previous-period">
                <?php echo ScoreConverter::display($_smarty_tpl->getVariable('previousValueObject')->value->getResultsScore());?>

            </td>
            <td class="content-line centered current-period">
                <?php echo ScoreConverter::display($_smarty_tpl->getVariable('valueObject')->value->getResultsScore());?>

            </td>
            <td class="content-line actions">
                <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasResultsScoreComment()||$_smarty_tpl->getVariable('previousValueObject')->value->hasResultsScoreComment()){?>
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink(EmployeeFinalResultView::RESULTS_NOTE_NAME);?>

                <?php }?>
                <?php }?>
            </td>
        </tr>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showRemarks()){?>
        <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasResultsScoreComment()||$_smarty_tpl->getVariable('previousValueObject')->value->hasResultsScoreComment()){?>
        <tr class="comment-row" id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId(EmployeeFinalResultView::RESULTS_NOTE_NAME);?>
" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?> style="display:none;"<?php }?>>
            <td class="content-line" colspan="100%" >
                <?php if ($_smarty_tpl->getVariable('valueObject')->value->hasResultsScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('assessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('valueObject')->value->getResultsScoreComment());?>
</span>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->getVariable('previousValueObject')->value->hasResultsScoreComment()){?>
                <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                    <strong><?php echo $_smarty_tpl->getVariable('previousAssessmentCycleValueObject')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('REMARKS');?>
</strong><br />
                    <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('previousValueObject')->value->getResultsScoreComment());?>
</span>
                </div>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td class="content-line" colspan="100%" >
            </td>
        </tr>
        <?php }?>
        <?php }?>
        <?php }?>
        <tr>
            <td colspan="100%">&nbsp;</td>
        </tr>
    </table>
</span>
<!-- /employeeFinalResultView.tpl -->