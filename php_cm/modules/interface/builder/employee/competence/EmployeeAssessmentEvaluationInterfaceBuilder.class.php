<?php

/**
 * Description of EmployeeAssessmentEvaluationInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/competence/EmployeeAssessmentEvaluationInterfaceBuilderComponents.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');

require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentEvaluationView.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentEvaluationEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentEvaluationDelete.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeAssessmentEvaluationHistory.class.php');
require_once('modules/interface/converter/state/AssessmentProcessEvaluationStateConverter.class.php');

require_once('modules/interface/state/AssessmentProcessEvaluationState.class.php');

class EmployeeAssessmentEvaluationInterfaceBuilder
{

    const VIEW_AS_SUBBLOCK      = TRUE;
    const VIEW_As_STANDALONE    = FALSE;

    static function getViewHtml($displayWidth,
                                $employeeId,
                                EmployeeAssessmentEvaluationValueObject $valueObject,
                                EmployeeAssessmentProcessValueObject $processValueObject,
                                $viewMode = self::VIEW_AS_SUBBLOCK)
    {
        $contentHtml = '';

        // functioneringsgesprek info
        $assessmentEvaluationId     = $valueObject->getId();
        $attachmentId               = $valueObject->getAttachmentId();
        $assessmentEvaluationStatus = $valueObject->getAssessmentEvaluationStatus();
        $isEvaluationDone           = $assessmentEvaluationStatus == AssessmentEvaluationStatusValue::EVALUATION_DONE;
        $attachmentLink             = EmployeeAssessmentEvaluationInterfaceBuilderComponents::getAttachmentLink($employeeId,
                                                                                                                $attachmentId);

        //welke onderdelen tonen
        $showEvaluationStatus   = CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS; // todo: naar service
        $showEvaluationDate     = $isEvaluationDone;
        $showAttachmentLink     = !empty($attachmentLink);

        $showContent = $showEvaluationStatus || $showEvaluationDate || $showAttachmentLink;

        if ($showContent) {
            $interfaceObject = EmployeeAssessmentEvaluationView::createWithValueObject($valueObject, $displayWidth);

            $interfaceObject->setAttachmentLink(        $attachmentLink);
            $interfaceObject->setShowAttachmentLink(    $showAttachmentLink);

            $interfaceObject->setShowEvaluationStatus(  $showEvaluationStatus);
            $interfaceObject->setShowEvaluationDate(    $showEvaluationDate);

            if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {

                $isEvaluationRequested      = $processValueObject->isEvaluationRequested();
                $assessmentProcessStatus    = $processValueObject->getAssessmentProcessStatus();
                $assesmentEvaluationState   = AssessmentProcessEvaluationState::determineProcessEvaluationState(    $assessmentEvaluationStatus,
                                                                                                                    $isEvaluationRequested,
                                                                                                                    $assessmentProcessStatus);
                // status label
                $interfaceObject->setEvaluationStateLabel(  AssessmentProcessEvaluationStateConverter::display($assesmentEvaluationState));

                $statusIcon = AssessmentProcessEvaluationState::determineEvaluationStatusIcon($assesmentEvaluationState);
                $title      = AssessmentEvaluationStatusConverter::display($assessmentEvaluationStatus);
                $interfaceObject->setStatusIconView(   AssessmentIconView::create($statusIcon, $title));
            }

            // en dat alles in een mooi blok laten zien
            $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                        TXT_UCF('ASSESSMENT_EVALUATION'),
                                                                        $displayWidth);
            $blockInterfaceObject->setIsSubHeader(      $viewMode == self::VIEW_AS_SUBBLOCK);

            if (empty($assessmentEvaluationId)) {
                $blockInterfaceObject->addActionLink(   EmployeeAssessmentEvaluationInterfaceBuilderComponents::getAddLink(     $employeeId));
            } else {
                $blockInterfaceObject->addActionLink(   EmployeeAssessmentEvaluationInterfaceBuilderComponents::getEditLink(    $employeeId,
                                                                                                                                $assessmentEvaluationId));
            }
            $blockInterfaceObject->addActionLink(       EmployeeAssessmentEvaluationInterfaceBuilderComponents::getRemoveLink(  $employeeId,
                                                                                                                                $assessmentEvaluationId));
            $blockInterfaceObject->addActionLink(       EmployeeAssessmentEvaluationInterfaceBuilderComponents::getHistoryLink( $employeeId));

            $contentHtml = $blockInterfaceObject->fetchHtml();
        }

        return array($showContent, $contentHtml);
    }

    static function getAddHtml( $displayWidth,
                                $employeeId)
    {
        $valueObject = EmployeeAssessmentEvaluationValueObject::createWithData( $employeeId,
                                                                                NULL);
        $valueObject->setAssessmentEvaluationStatus(    AssessmentEvaluationStatusValue::EVALUATION_NO);
        return self::getEditHtmlForValueObject( $displayWidth,
                                                $employeeId,
                                                $valueObject);
    }

    static function getEditHtml($displayWidth,
                                $employeeId,
                                $assessmentEvaluationId)
    {
        $valueObject = EmployeeAssessmentEvaluationService::getValueObjectById( $employeeId,
                                                                                $assessmentEvaluationId);
        return self::getEditHtmlForValueObject( $displayWidth,
                                                $employeeId,
                                                $valueObject);
    }

    private static function getEditHtmlForValueObject(  $displayWidth,
                                                        $employeeId,
                                                        EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        $attachmentId = $valueObject->getAttachmentId();

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT_EVALUATION);
        $safeFormHandler->storeSafeValue('employeeId', $employeeId);

        $safeFormHandler->addDateInputFormatType(   'assessment_evaluation_date');
        $safeFormHandler->addIntegerInputFormatType('assessment_evaluation_status');
        $safeFormHandler->finalizeDataDefinition();

        // via sessie doorgeven aan de upload attachment code
        $_SESSION['ID_E'] = $employeeId;
        EmployeeAssessmentEvaluationService::storeUploadedEvaluationDocumentId($attachmentId);


        $interfaceObject = EmployeeAssessmentEvaluationEdit::createWithValueObject( $valueObject,
                                                                                    $displayWidth);
        // afhankelijk van de proces status de keuzes aanpassen...
        $interfaceObject->setAssessmentEvaluationStatusValues(  AssessmentEvaluationStatusValue::values());
        $interfaceObject->setAssessmentEvaluationDatePicker(    InterfaceBuilderComponents::getCalendarInputPopupHtml(  'assessment_evaluation_date',
                                                                                                                        $valueObject->getAssessmentEvaluationDate()));
        $interfaceObject->setShowUpload(                        empty($attachmentId));
        $interfaceObject->setAttachmentLink(                    EmployeeAssessmentEvaluationInterfaceBuilderComponents::getAttachmentLink(  $employeeId,
                                                                                                                                            $attachmentId));
        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml, $interfaceObject->getShowUpload());
    }


    /// HISTORY
    static function getHistoryHtml( $displayWidth,
                                    $employeeId,
                                    Array /* EmployeeAssessmentEvaluationValueObject */ $valueObjects)
    {
        $historyInterfaceObject = EmployeeAssessmentEvaluationHistory::create($displayWidth);

        foreach ($valueObjects as $valueObject) {
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->getSavedDatetime());
            $valueObject->setAssessmentCycleValueObject($historyPeriod);
            $valueObject->setAttachmentLink( EmployeeAssessmentEvaluationInterfaceBuilderComponents::getAttachmentLink( $employeeId,
                                                                                                                        $valueObject->getAttachmentId()));
            $historyInterfaceObject->addValueObject($valueObject);
        }

        return $historyInterfaceObject->fetchHtml();
    }

    static function getRemoveHtml(  $displayWidth,
                                    $employeeId,
                                    EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__DELETE_ASSESSEMENT_EVALUATION);

        $safeFormHandler->storeSafeValue('employeeId',              $employeeId);
        $safeFormHandler->storeSafeValue('assessmentEvaluationId',  $valueObject->getId());
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = EmployeeAssessmentEvaluationDelete::createWithValueObject(   $valueObject,
                                                                                        $displayWidth);
        $interfaceObject->setAttachmentLink(    EmployeeAssessmentEvaluationInterfaceBuilderComponents::getAttachmentLink(  $employeeId,
                                                                                                                            $valueObject->getAttachmentId()));
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_CLEAR_THE_EVALUATION'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
