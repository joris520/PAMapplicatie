<?php

/**
 * Description of AssessmentActionInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/process/list/EmployeeListInterfaceProcessor.class.php');
require_once('modules/interface/state/AssessmentProcessActionButton.class.php');
require_once('modules/interface/builder/assessmentProcess/AssessmentActionPageBuilder.class.php');

class AssessmentActionInterfaceProcessor
{

    const CONTENT_HEIGHT = 220;
    const DIALOG_WIDTH   = ApplicationInterfaceBuilder::DIALOG_WIDTH;

    const CHECKBOX_NOT_CHECKED  = 0;
    const CHECKBOX_CHECKED      = 1;

    static function displayVerifyAction($objResponse, $bossId, $processAction)
    {
        if (PermissionsService::isExecuteAllowed(AssessmentProcessActionButton::getPermissionForAction($processAction))) {

            $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentActionPageBuilder::getConfirmActionPopupHtml(self::DIALOG_WIDTH,
                                                                                self::CONTENT_HEIGHT,
                                                                                $bossId,
                                                                                $processAction,
                                                                                $currentAssessmentCycle);

            InterfaceXajax::showActionDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT);
        }
    }

    // na een wijziging door een actie de employee lijst verversen
    static function finishAction($objResponse, AssessmentProcessResultValueObject $resultValueObject)
    {
        //InterfaceXajax::closeFormDialog($objResponse);
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);

        $popupHtml = AssessmentActionPageBuilder::getActionResultPopupHtml( self::DIALOG_WIDTH,
                                                                            self::CONTENT_HEIGHT,
                                                                            $resultValueObject);

        InterfaceXajax::showInfoDialog( $objResponse,
                                        $popupHtml,
                                        self::DIALOG_WIDTH,
                                        self::CONTENT_HEIGHT);

        InterfaceXajax::changePopupBorderColor($objResponse, COLOUR_MESSAGE_SUCCESS);

    }


    static function toggleEvaluationInvited($objResponse, $employeeId, $checkboxNewValue)//$employeeAssessmentProcessId, $currentValue, $scoreRank)
    {
        $checkboxNewValue = empty($checkboxNewValue) ? self::CHECKBOX_NOT_CHECKED : intval($checkboxNewValue);
        if ($checkboxNewValue == self::CHECKBOX_CHECKED || $checkboxNewValue == self::CHECKBOX_NOT_CHECKED) {
            // data ophalen
            $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();
            $employeeAssessmentProcess = EmployeeAssessmentProcessService::getValueObject(  $employeeId,
                                                                                            AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                                                                            $currentAssessmentCycle);

            if ($employeeAssessmentProcess->hasId()) {
                // scherm updaten
                if (!$employeeAssessmentProcess->hasScoreRank()) {
                    // als dit een "los" evaluatieverzoek is (dus niet via top/bottom/diff) dan de achtergrond kleur aanpassen
                    EmployeeListInterfaceProcessor::toggleCheckboxBackground($objResponse, $employeeId, $checkboxNewValue);
                }
                // database updaten
                $newRequestStatus = $checkboxNewValue == self::CHECKBOX_CHECKED ? AssessmentProcessEvaluationRequestValue::REQUESTED : AssessmentProcessEvaluationRequestValue::NOT_REQUESTED;
                EmployeeAssessmentProcessService::updateEvaluationRequestStatus($employeeId, $employeeAssessmentProcess->getId(), $newRequestStatus);
            }
        }
    }

}

?>
