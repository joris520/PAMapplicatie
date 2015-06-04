<?php

/**
 * Description of AssessmentActionInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/assessmentProcess/AssessmentActionService.class.php');
require_once('modules/model/service/report/AssessmentReportService.class.php');
require_once('modules/model/service/report/SelfAssessmentReportService.class.php');

require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');
require_once('modules/model/state/assessmentProcess/AssessmentProcessActionState.class.php');

require_once('modules/interface/converter/assessmentProcess/AssessmentProcessStatusConverter.class.php');
require_once('modules/interface/converter/state/AssesssmentProcessActionStateConverter.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionView.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/BossAssessmentProcessActionView.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionCloseInvitationsConfirm.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionCloseInvitationsResult.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionEvaluationsSelectedResult.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionConfirm.class.php');
require_once('modules/interface/interfaceobjects/assessmentProcess/AssessmentProcessActionResult.class.php');

require_once('modules/interface/builder/assessmentProcess/AssessmentActionInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/assessmentInvitation/AssessmentInvitationInterfaceBuilderComponents.class.php');

require_once('modules/interface/builder/assessmentProcess/AssessmentActionConfirmInterfaceBuilder.class.php');
require_once('modules/interface/builder/assessmentProcess/AssessmentActionResultInterfaceBuilder.class.php');

class AssessmentActionInterfaceBuilder
{

    const REPLACE_HTML_ID = 'assessment_process_action';

    static function getActionHtml(  $displayWidth,
                                    $actionContentHtml)
    {
        $interfaceObject = AssessmentProcessActionView::create($displayWidth);
        $interfaceObject->setReplaceHtmlId( self::REPLACE_HTML_ID);
        $interfaceObject->setActionHtml(    $actionContentHtml);

        return $interfaceObject->fetchHtml();
    }


    static function getActionContentHtml(   $displayWidth,
                                            $formId,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        // filter....
        $bossFilterValue = EmployeeFilterService::retrieveBossFilter();
        list($selectIsBossDymmy, $selectHasNoBossDummy, $selectedBossId, $bossFilterState) = BossFilterValue::explainValue($bossFilterValue);
        $isActionAllowed = !empty($selectedBossId) && $bossFilterState == BossFilterState::BOSSID_SELECTED;

        // safeForm
        $safeActionHandler = SafeActionHandler::create(SAFEFORM_EMPLOYEE__PROCESS_ACTION);
        $safeActionHandler->storeSafeValue('filterState', $bossFilterState);
        if ($isActionAllowed) {
            $safeActionHandler->storeSafeValue('bossId', $selectedBossId);
        }

        $safeActionHandler->finalizeDataDefinition();


        $safeFormIdentifier = $safeActionHandler->getFormIdentifier();

        // opbouwen interface
        $interfaceObject = BossAssessmentProcessActionView::create($displayWidth);

        if ($isActionAllowed) {
            // actions opbouwen..
            // huidige process status ophalen
            $valueObject = BossAssessmentProcessService::getValueObject($selectedBossId, $assessmentCycle);
            //$debugMessage = print_r($valueObject,true);
            $assessmentProcessStatus = $valueObject->getAssessmentProcessStatus();

            $interfaceObject->setActionMessage(AssessmentProcessStatusConverter::display($assessmentProcessStatus));

            $possibleAction = AssessmentActionService::getPossibleAction($assessmentProcessStatus);

            switch($possibleAction) {
                case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
                    $interfaceObject->setAction(    AssessmentActionInterfaceBuilderComponents::getSelectedAction($safeFormIdentifier, $formId, $possibleAction));
                    break;
            }
            $possibleUndoAction = AssessmentActionService::getPossibleUndoAction($assessmentProcessStatus);
            switch($possibleUndoAction) {
                case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
                    $interfaceObject->setUndo(  AssessmentActionInterfaceBuilderComponents::getSelectedUndo($safeFormIdentifier, $formId, $possibleUndoAction));
                    break;
            }

        } else {
            $interfaceObject->setActionMessage(TXT_UCF('THESE_ACTIONS_AVAILABLE_WITH_A_SELECTED_BOSS'));
        }

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeActionHandler, $contentHtml);
    }


}

?>
