<?php

/**
 * Description of AssessmentActionConfirmInterfaceBuilder
 *
 * @author ben.dokter
 */

class AssessmentActionConfirmInterfaceBuilder
{

    static function getConfirmActionHtml(   $displayWidth,
                                            $bossId,
                                            $action,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__VERIFY_ACTION);
        $safeFormHandler->storeSafeValue('action', $action);
        $safeFormHandler->storeSafeValue('bossId', $bossId);
        $safeFormHandler->finalizeDataDefinition();

        $title = AssesssmentProcessActionStateConverter::display($action);

        $bossName = '';
        if (!empty($bossId)) {
            $bossIdValue = EmployeeSelectService::getBossIdValue($bossId);
            $bossName = $bossIdValue->getValue();
        }
        switch($action) {
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $contentHtml = self::generateMarkSelfAssessmentCompleteConfirmActionHtml($displayWidth, $bossId, $bossName, $assessmentCycle);
                break;
            default:
                $contentHtml = self::generateConfirmActionHtml($displayWidth, $bossId, $bossName, $action);
        }

        return array($safeFormHandler, $contentHtml, $title);
    }

    private static function generateMarkSelfAssessmentCompleteConfirmActionHtml($displayWidth,
                                                                                $bossId,
                                                                                $bossName,
                                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $confirmHtml = '';
        if (!empty($bossId)) {
            $selfAssessmentsNotCompletedCount = 0;
            $assessmentsNotCompletedCount = 0;

            $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);
            if (!empty($allowedEmployeeIds)) {
                $selfAssessmentsNotCompletedCount   = SelfAssessmentReportService::getInvitationsNotCompletedCount($allowedEmployeeIds, $assessmentCycle);
                $assessmentsNotCompletedCount       = AssessmentReportService::getAssessmentNotCompletedCount($allowedEmployeeIds, $assessmentCycle);
            }
            $userIsThisBoss = USER_EMPLOYEE_IS_BOSS && $bossId == EMPLOYEE_ID;

            $bossLabel = $userIsThisBoss ? '' : ' van ZoCo ' . $bossName;
            $youLabel =  $userIsThisBoss ? 'u' : 'de ZoCo' ;

            $interfaceObject = AssessmentProcessActionCloseInvitationsConfirm::create($displayWidth);
            $interfaceObject->setSelfAssessmentsNotCompletedCount(  $selfAssessmentsNotCompletedCount);
            $interfaceObject->setAssessmentsNotCompletedCount(      $assessmentsNotCompletedCount);
            $interfaceObject->setBossLabel( $bossLabel);
            $interfaceObject->setYouLabel(  $youLabel);

            $confirmHtml = $interfaceObject->fetchHtml();
        }
        return $confirmHtml;
    }

    private static function generateConfirmActionHtml(  $displayWidth,
                                                        $bossId,
                                                        $bossName,
                                                        $action)
    {
        $userIsThisBoss = USER_EMPLOYEE_IS_BOSS && $bossId == EMPLOYEE_ID;

        $bossLabel = $userIsThisBoss ? '' : 'ZoCo ' . $bossName;

        $interfaceObject = AssessmentProcessActionConfirm::create($displayWidth);
        $interfaceObject->setBossLabel( $bossLabel);
        $interfaceObject->setMessage( AssesssmentProcessActionStateConverter::messageConfirm($action));

        return $interfaceObject->fetchHtml();
    }



}

?>
