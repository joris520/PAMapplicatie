<?php /* Smarty version Smarty-3.0.7, created on 2014-05-26 16:05:35
         compiled from "C:\xampp\htdocs\gino-pam\php_cm/modules/interface/templates\employee/competence/employeeCompetenceScoreView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:404753834a2fdf2ab1-95932777%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6b5e2b6774242dc3c2fdac2f7e388376046f651' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gino-pam\\php_cm/modules/interface/templates\\employee/competence/employeeCompetenceScoreView.tpl',
      1 => 1379954116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '404753834a2fdf2ab1-95932777',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- employeeCompetenceScoreView.tpl -->
    <?php $_smarty_tpl->tpl_vars['competenceValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getEmployeeCompetenceValueObject(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['scoreValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getCurrentScoreValueObject(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['previousScoreValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getPreviousScoreValueObject(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['employeeScoreValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getCurrentSelfAssessmentScoreValueObject(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['previousEmployeeScoreValueObject'] = new Smarty_variable($_smarty_tpl->getVariable('interfaceObject')->value->getPreviousSelfAssessmentScoreValueObject(), null, null);?>

    <?php $_smarty_tpl->tpl_vars['currentAssessmentCycle'] = new Smarty_variable($_smarty_tpl->getVariable('scoreValueObject')->value->getAssessmentCycleValueObject(), null, null);?>
    <?php $_smarty_tpl->tpl_vars['previousAssessmentCycle'] = new Smarty_variable($_smarty_tpl->getVariable('previousScoreValueObject')->value->getAssessmentCycleValueObject(), null, null);?>
    <tr id="competence_row_<?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->getCompetenceId();?>
"
        class="<?php if ($_smarty_tpl->getVariable('competenceValueObject')->value->competenceIsMain){?> main_competence<?php }?>"
        onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDetailLinkId();?>
" class="clickable content-line<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasClusterMainCompetence()){?><?php if ($_smarty_tpl->getVariable('competenceValueObject')->value->competenceIsMain){?> main_competence<?php }else{ ?> sub_competence<?php }?><?php }?>" onClick="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDetailOnClick();?>
;return false;">
            <span class="activeRow icon-style" onClick="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getDetailOnClick();?>
;return false;">
                <img src="<?php echo constant('ICON_INFO');?>
" title="<?php echo TXT_UCF('SHOW_DETAILS');?>
">
            </span>
            <span width="40px"><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getIsKeySymbol();?>
</span>
            <span><?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->competenceName;?>
</span><?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getSymbolIsAdditionalCompetence();?>

        </td>
        <td class=" content-line centered">
            <?php $_smarty_tpl->tpl_vars['managerPreviousScore'] = new Smarty_variable($_smarty_tpl->getVariable('previousScoreValueObject')->value->getScore(), null, null);?>
            <?php echo ScoreConverter::employeeScoreText($_smarty_tpl->getVariable('managerPreviousScore')->value,$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewPreviousScore());?>

        </td>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360()){?>
        <?php $_smarty_tpl->tpl_vars['previousEmployeeScore'] = new Smarty_variable($_smarty_tpl->getVariable('previousEmployeeScoreValueObject')->value->getScore(), null, null);?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewPreviousEmployeeScore()){?>
        <td class="content-line centered<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getPreviousDiffIndicator();?>
" title="<?php echo ScoreConverter::tooltipTitle($_smarty_tpl->getVariable('previousEmployeeScore')->value,$_smarty_tpl->getVariable('interfaceObject')->value->previousIsInvited());?>
">
            <?php echo ScoreConverter::display($_smarty_tpl->getVariable('previousEmployeeScore')->value);?>

        </td>
        <?php }else{ ?>
        <td class="content-line centered" title="<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->previousIsInvited()){?><?php echo TXT_UCF('SCORE_STATUS_INFO_TEXT');?>
<?php }?>"><?php if ($_smarty_tpl->getVariable('interfaceObject')->value->previousIsInvited()){?><?php echo ScoreConverter::employeeScoreText($_smarty_tpl->getVariable('previousEmployeeScore')->value,false);?>
<?php }else{ ?>-<?php }?></td>
        <?php }?>
        <?php }?>
        <td class="content-line centered<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasClusterMainCompetence()){?><?php if ($_smarty_tpl->getVariable('competenceValueObject')->value->competenceIsMain){?> main_competence<?php }else{ ?> current-period<?php }?><?php }else{ ?> current-period<?php }?>"
            style="<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasClusterMainCompetence()){?><?php if ($_smarty_tpl->getVariable('competenceValueObject')->value->competenceIsMain){?> background-color:#eee<?php }else{ ?><?php }?><?php }?>">
            <?php $_smarty_tpl->tpl_vars['managerScore'] = new Smarty_variable($_smarty_tpl->getVariable('scoreValueObject')->value->getScore(), null, null);?>
            <?php echo ScoreConverter::employeeScoreText($_smarty_tpl->getVariable('managerScore')->value,$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewCurrentScore());?>

        </td>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360()){?>
        <?php $_smarty_tpl->tpl_vars['currentEmployeeScore'] = new Smarty_variable($_smarty_tpl->getVariable('employeeScoreValueObject')->value->score, null, null);?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewCurrentEmployeeScore()){?>
        <td class="content-line centered<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getCurrentDiffIndicator();?>
 current-period" title="<?php echo ScoreConverter::tooltipTitle($_smarty_tpl->getVariable('currentEmployeeScore')->value,$_smarty_tpl->getVariable('interfaceObject')->value->currentIsInvited());?>
">
            <?php echo ScoreConverter::display($_smarty_tpl->getVariable('currentEmployeeScore')->value);?>

        </td>
        <?php }else{ ?>
        <td class="content-line centered current-period" title="<?php if ($_smarty_tpl->getVariable('interfaceObject')->value->currentIsInvited()){?><?php echo TXT_UCF('SCORE_STATUS_INFO_TEXT');?>
<?php }?>"><?php if ($_smarty_tpl->getVariable('interfaceObject')->value->currentIsInvited()){?><?php echo ScoreConverter::employeeScoreText($_smarty_tpl->getVariable('currentEmployeeScore')->value,false);?>
<?php }else{ ?>-<?php }?></td>
        <?php }?>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showNorm()){?>
        <td class="content-line centered"><?php echo NormConverter::display($_smarty_tpl->getVariable('competenceValueObject')->value->competenceFunctionNorm);?>
</td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showWeight()){?>
        <td class="content-line centered"><?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->competenceFunctionWeight;?>
</td>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showPdpActions()){?>
        <td class="content-line centered"><?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->pdpActionCount;?>
</td>
        <?php }?>
        <td class="content-line " style="text-align:right">
            <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showAnyRemarks()&&$_smarty_tpl->getVariable('interfaceObject')->value->hasNotes()){?>
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteVisibilityLink();?>

            <?php }?>
                <?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getHistoryLink();?>

        </td>
    </tr>
    <tr id="detail_row_<?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->competenceId;?>
" class="hidden-info">
        <td colspan="100%" id="detail_content_<?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->competenceId;?>
" style="padding-left: 10px;"></td>
    </tr>
    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showAnyRemarks()||$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewCurrentScore()||$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewPreviousScore()){?>
        <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->hasNotes()){?>
            <?php $_smarty_tpl->tpl_vars['commentIndentation'] = new Smarty_variable('margin-left:40px', null, null);?>
            <?php $_smarty_tpl->tpl_vars['didShowRemarks'] = new Smarty_variable(false, null, null);?>
            <tr id="<?php echo $_smarty_tpl->getVariable('interfaceObject')->value->getToggleNoteId($_smarty_tpl->getVariable('competenceValueObject')->value->getCompetenceId());?>
" class="comment-row" <?php if (!$_smarty_tpl->getVariable('interfaceObject')->value->isInitialVisibleNotes()){?> style="display:none;"<?php }?>>
                <td class="content-line" colspan="100%">
                    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showBossRemarks()&&$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewCurrentScore()&&$_smarty_tpl->getVariable('scoreValueObject')->value->hasNote()){?>
                    <?php $_smarty_tpl->tpl_vars['didShowRemarks'] = new Smarty_variable(true, null, null);?>
                    <div class="remarks-content " style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                        <strong><?php echo $_smarty_tpl->getVariable('currentAssessmentCycle')->value->getAssessmentCycleName();?>
 <?php echo TXT_LC(constant('CUSTOMER_MANAGER_REMARKS_LABEL'));?>
</strong><br />
                        <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('scoreValueObject')->value->getNote());?>
<span>
                    </div>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360Remarks()&&$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewCurrentEmployeeScore()&&$_smarty_tpl->getVariable('employeeScoreValueObject')->value->hasNote()){?>
                    <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                        <strong><?php echo $_smarty_tpl->getVariable('currentAssessmentCycle')->value->getAssessmentCycleName();?>
  <?php echo TXT_LC('EMPLOYEE_REMARKS');?>
</strong><br />
                        <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('employeeScoreValueObject')->value->getNote());?>
</span>
                    </div>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->showBossRemarks()&&$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewPreviousScore()&&$_smarty_tpl->getVariable('previousScoreValueObject')->value->hasNote()){?>
                    <?php $_smarty_tpl->tpl_vars['didShowRemarks'] = new Smarty_variable(true, null, null);?>
                    <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                        <strong><?php echo $_smarty_tpl->getVariable('previousAssessmentCycle')->value->getAssessmentCycleName();?>
 <?php echo TXT_LC(constant('CUSTOMER_MANAGER_REMARKS_LABEL'));?>
</strong><br />
                        <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('previousScoreValueObject')->value->getNote());?>
</span>
                    </div>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('interfaceObject')->value->show360Remarks()&&$_smarty_tpl->getVariable('interfaceObject')->value->isAllowedViewPreviousEmployeeScore()&&$_smarty_tpl->getVariable('previousEmployeeScoreValueObject')->value->hasNote()){?>
                    <?php $_smarty_tpl->tpl_vars['didShowRemarks'] = new Smarty_variable(true, null, null);?>
                    <div class="remarks-content" style="<?php echo $_smarty_tpl->getVariable('commentIndentation')->value;?>
; padding:10px;">
                        <strong><?php echo $_smarty_tpl->getVariable('previousAssessmentCycle')->value->getAssessmentCycleName();?>
 <?php echo TXT_LC('EMPLOYEE_REMARKS');?>
</strong><br />
                        <span class="comment"><?php echo nl2br($_smarty_tpl->getVariable('previousEmployeeScoreValueObject')->value->getNote());?>
</span>
                    </div>
                    <?php }?>
                </td>
            </tr>
            <?php if ($_smarty_tpl->getVariable('didShowRemarks')->value){?>
            <tr>
                <td id="spacer_comment_row_<?php echo $_smarty_tpl->getVariable('competenceValueObject')->value->getCompetenceId();?>
" class="comment-row" style="display:none;" colspan="100%">&nbsp;</td>
            </tr>
            <?php }?>
        <?php }?>
    <?php }?>
<!-- /employeeCompetenceScoreView.tpl -->