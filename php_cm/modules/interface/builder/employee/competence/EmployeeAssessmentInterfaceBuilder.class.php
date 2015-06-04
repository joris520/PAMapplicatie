<?php

// components
require_once('modules/interface/builder/employee/competence/EmployeeAssessmentInterfaceBuilderComponents.class.php');

// services
require_once('modules/model/service/employee/competence/EmployeeAssessmentService.class.php');
// values
require_once('modules/model/value/employee/competence/ScoreStatusValue.class.php');

// interface objects
require_once('modules/interface/state/SelfAssessmentInvitationState.class.php');
require_once('modules/interface/converter/state/SelfAssessmentInvitationStateConverter.class.php');


require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentView.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentHistory.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentResend.class.php');

// converters
require_once('modules/interface/converter/employee/competence/ScoreStatusConverter.class.php');

class EmployeeAssessmentInterfaceBuilder
{
    const SHOW_NOTES = TRUE;
    const HIDE_NOTES = FALSE;

    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeAssessmentValueObject $valueObject,
                                EmployeeAssessmentCollection $collection,
                                $showAsStandAlone)
    {
        $assessmentId = $valueObject->getId();

        $interfaceObject = EmployeeAssessmentView::createWithValueObject(   $valueObject,
                                                                            $displayWidth);

        $interfaceObject->setShowAssessmentNote(        self::HIDE_NOTES);
        $interfaceObject->setIsViewAllowedScoreStatus(  PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE));

        $interfaceObject->setShowSelfAssessment(        CUSTOMER_OPTION_USE_SELFASSESSMENT && !CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS);

        $invitationHash         = $collection->getHashId();
        $invitationState        = SelfAssessmentInvitationState::determineState($collection);
        $resendAllowed          = $invitationState == SelfAssessmentInvitationState::INVITED_SENT;

        $interfaceObject->setSelfAssessmentState(   $invitationState);
        $interfaceObject->setShowCompletedStatus(   false);
        $interfaceObject->setCompletedStatus(       $collection->getCompleted());

        // en dat alles in een mooi blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('ASSESSMENT'),
                                                                    $displayWidth);
        $blockInterfaceObject->setHasFooter(!$showAsStandAlone);
        if (empty($assessmentId)) {
            $blockInterfaceObject->addActionLink(   EmployeeAssessmentInterfaceBuilderComponents::getAddLink($employeeId));
        } else {
            $blockInterfaceObject->addActionLink(   EmployeeAssessmentInterfaceBuilderComponents::getEditLink($employeeId));
        }
        $blockInterfaceObject->addActionLink(       EmployeeAssessmentInterfaceBuilderComponents::getResendInvitationLink(  $employeeId,
                                                                                                                            $invitationHash,
                                                                                                                            $resendAllowed));
        $blockInterfaceObject->addActionLink(       EmployeeAssessmentInterfaceBuilderComponents::getHistoryLink($employeeId));

        return $blockInterfaceObject->fetchHtml();
    }


    static function getEditHtml($displayWidth,
                                $employeeId,
                                EmployeeAssessmentValueObject $valueObject)
    {

        return self::getEditHtmlForValueObject( $displayWidth,
                                                $employeeId,
                                                $valueObject);
    }

    private static function getEditHtmlForValueObject(  $displayWidth,
                                                        $employeeId,
                                                        EmployeeAssessmentValueObject $valueObject)
    {
        $isEditAllowedScoreStatus = PermissionsService::isEditAllowed(  PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE);
        $isViewAllowedScoreStatus = PermissionsService::isViewAllowed(  PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE);

        // safeForm
        $safeFormHandler = SafeFormHandler::create( SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT);

        $safeFormHandler->storeSafeValue('employeeId',                  $employeeId);
        $safeFormHandler->storeSafeValue('isEditAllowedScoreStatus',    $isEditAllowedScoreStatus);
        if ($isEditAllowedScoreStatus) { // doorgeven, via edit of via safeValue
            $safeFormHandler->addIntegerInputFormatType('score_status');
            $safeFormHandler->addStringInputFormatType( 'assessment_note');
        }
        $safeFormHandler->addDateInputFormatType(       'assessment_date');
        $safeFormHandler->finalizeDataDefinition();


        $interfaceObject = EmployeeAssessmentEdit::createWithValueObject(   $valueObject,
                                                                            $displayWidth);
        $interfaceObject->setShowAssessmentNote(        self::HIDE_NOTES);

        $interfaceObject->setIsEditAllowedScoreStatus(  $isEditAllowedScoreStatus);
        $interfaceObject->setIsViewAllowedScoreStatus(  $isViewAllowedScoreStatus);
        $interfaceObject->setAssessmentDatePicker(      InterfaceBuilderComponents::getCalendarInputPopupHtml(  'assessment_date',
                                                                                                                $valueObject->getAssessmentDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);

    }


    /// HISTORY
    static function getHistoryHtml($displayWidth, $employeeId)
    {
        $historyInterfaceObject = EmployeeAssessmentHistory::create($displayWidth);
        $historyInterfaceObject->setIsViewAllowedScoreStatus(   PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE));

        // ophalen answers

        $valueObjects = EmployeeAssessmentService::getValueObjects($employeeId);
        foreach ($valueObjects as $valueObject) {
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDatetime());
            $valueObject->setAssessmentCycleValueObject($historyPeriod);
            $historyInterfaceObject->addValueObject($valueObject);
        }

        return $historyInterfaceObject->fetchHtml();
    }

    static function getResendAssessmentInvitationHtml(  $displayWidth,
                                                        $employeeId,
                                                        $hashId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject     = EmployeeSelfAssessmentInvitationService::getValueObject($employeeId, $assessmentCycle);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__RESEND_SELF_ASSESSEMENT_INVITATION);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->storeSafeValue('requestedHashId', $hashId);
        $safeFormHandler->storeSafeValue('currentHashId', $valueObject->getHashId());
        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = EmployeeAssessmentResend::create($displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_RESEND_THE_INVITATION'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}

?>
