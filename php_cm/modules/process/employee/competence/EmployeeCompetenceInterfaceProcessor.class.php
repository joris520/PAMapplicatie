<?php

/**
 * Description of EmployeeScoresInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/competence/EmployeeCompetencePageBuilder.class.php');
require_once('modules/process/list/EmployeeListInterfaceProcessor.class.php');
require_once('modules/process/tab/EmployeesTabInterfaceProcessor.class.php');
require_once('modules/model/service/employee/document/EmployeeDocumentService.class.php');

class EmployeeCompetenceInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const SCORE_CONTENT_HEIGHT = 450;
    const SCORE_DIALOG_WIDTH = 800;
    const ANSWER_CONTENT_HEIGHT = 350;
    const ASSESSMENT_CONTENT_HEIGHT = 130;
    const ASSESSMENT_EVALUATION_CONTENT_HEIGHT = 130;
    const ASSESSMENT_EVALUATION_UPLOAD_HEIGHT = 200;
    const HISTORY_CONTENT_HEIGHT = 320;
    const FUNCTION_CONTENT_HEIGHT = 350;
    const HISTORY_WIDTH = ApplicationInterfaceBuilder::HISTORY_WIDTH;
    const DIALOG_WIDTH = ApplicationInterfaceBuilder::DIALOG_WIDTH;

    const ASSESSMENT_EDIT_MODE_SCORE       = 1;
    const ASSESSMENT_EDIT_MODE_ASSESSMENT  = 2;

    static function displayView($objResponse, $employeeId, $clusterId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);

                // assessment cycles ophalen
                $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
                $previousPeriod = AssessmentCycleService::getPreviousValueObject($currentPeriod->getStartDate());

                // de data verzamelen
                $employeeCompetenceCollection = EmployeeCompetenceService::getCollection($employeeId, $currentPeriod, $previousPeriod);
                $assessmentProcessValueObject = EmployeeAssessmentProcessService::getValueObject(   $employeeId,
                                                                                                    AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
                                                                                                    $currentPeriod);

                $viewHtml = EmployeeCompetencePageBuilder::getPageHtml( self::DISPLAY_WIDTH,
                                                                        $employeeId,
                                                                        $employeeInfoValueObject,
                                                                        $employeeCompetenceCollection,
                                                                        $assessmentProcessValueObject,
                                                                        $clusterId);
            }
            EmployeesTabInterfaceProcessor::displayContent($objResponse, $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu($objResponse, $employeeId, MODULE_EMPLOYEE_SCORE);
        }
    }

    static function displayEditBulkScore($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
            $employeeCompetenceScoreCollection =
                    EmployeeCompetenceService::getEmployeeCompetenceCategoryClusterScoreCollection( $employeeId,
                                                                                                    EmployeeCompetenceService::EXCLUDE_360,
                                                                                                    $currentPeriod);

            $popupHtml = EmployeeCompetencePageBuilder::getEditBulkScorePopupHtml(  self::SCORE_DIALOG_WIDTH,
                                                                                    self::SCORE_CONTENT_HEIGHT,
                                                                                    $employeeId,
                                                                                    $employeeCompetenceScoreCollection);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::SCORE_DIALOG_WIDTH,
                                            self::SCORE_CONTENT_HEIGHT);
        }
    }

    static function finishEditBulkScore($objResponse, $employeeId)
    {
        self::displayEditAssessment($objResponse, $employeeId, self::ASSESSMENT_EDIT_MODE_SCORE);
    }

    static function displayEditClusterScore($objResponse, $employeeId, $clusterId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
            $employeeClusterScoreCollection =
                    EmployeeCompetenceService::getEmployeeCompetenceClusterScoreCollection( $employeeId,
                                                                                            $clusterId,
                                                                                            EmployeeCompetenceService::EXCLUDE_360,
                                                                                            $currentPeriod);

            $popupHtml = EmployeeCompetencePageBuilder::getEditClusterScorePopupHtml(   self::SCORE_DIALOG_WIDTH,
                                                                                        self::SCORE_CONTENT_HEIGHT,
                                                                                        $employeeId,
                                                                                        $employeeClusterScoreCollection);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::SCORE_DIALOG_WIDTH,
                                            self::SCORE_CONTENT_HEIGHT);
        }
    }

    static function finishEditClusterScore($objResponse, $employeeId, $clusterId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId, $clusterId);
    }


    static function displayHistoryScore($objResponse, $employeeId, $competenceId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $popupHtml = EmployeeCompetencePageBuilder::getHistoryScorePopupHtml(   self::HISTORY_WIDTH,
                                                                                    self::HISTORY_CONTENT_HEIGHT,
                                                                                    $employeeId,
                                                                                    $competenceId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

    static function displayEditAnswer($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {

            $popupHtml = EmployeeCompetencePageBuilder::getEditAnswerPopupHtml( self::DIALOG_WIDTH,
                                                                                self::ANSWER_CONTENT_HEIGHT,
                                                                                $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::ANSWER_CONTENT_HEIGHT);
        }
    }

    static function finishEditAnswer($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }

    static function displayHistoryAnswer($objResponse, $employeeId, $questionId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $popupHtml = EmployeeCompetencePageBuilder::getHistoryQuestionAnswerPopupHtml(  self::HISTORY_WIDTH,
                                                                                            self::HISTORY_CONTENT_HEIGHT,
                                                                                            $employeeId,
                                                                                            $questionId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

    static function displayAddAssessment($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $valueObject = EmployeeAssessmentValueObject::createWithValues( $employeeId,
                                                                            DateUtils::getCurrentDatabaseDate(),
                                                                            ScoreStatusValue::PRELIMINARY,
                                                                            NULL);

            $popupHtml = EmployeeCompetencePageBuilder::getAddAssessmentPopupHtml(  self::DIALOG_WIDTH,
                                                                                    self::ASSESSMENT_CONTENT_HEIGHT,
                                                                                    $employeeId,
                                                                                    $valueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::ASSESSMENT_CONTENT_HEIGHT);
        }
    }

    static function displayEditAssessment(  $objResponse,
                                            $employeeId,
                                            $displayMode = self::ASSESSMENT_EDIT_MODE_ASSESSMENT)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();
            $valueObject = EmployeeAssessmentService::getValueObject(   $employeeId,
                                                                        $currentAssessmentCycle);

            //$displayMode = self::ASSESSMENT_EDIT_MODE_ASSESSMENT;
            $dialogWidth = $displayMode == self::ASSESSMENT_EDIT_MODE_SCORE     ?
                                                self::SCORE_DIALOG_WIDTH        :
                                                self::DIALOG_WIDTH;
            $dialogHeight = $displayMode == self::ASSESSMENT_EDIT_MODE_SCORE    ?
                                                self::SCORE_CONTENT_HEIGHT      :
                                                self::ASSESSMENT_CONTENT_HEIGHT;

            $popupHtml = EmployeeCompetencePageBuilder::getEditAssessmentPopupHtml( $dialogWidth,
                                                                                    $dialogHeight,
                                                                                    $employeeId,
                                                                                    $valueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            $dialogWidth,
                                            $dialogHeight);
        }
    }

    static function finishEditAssessment($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // refresh medewerkerslijst
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);

        self::displayView($objResponse, $employeeId);
    }

    static function displayResendSelfAssessmentInvitation($objResponse, $employeeId, $hashId)
    {
        if (PermissionsService::isExecuteAllowed(PERMISSION_EMPLOYEE_RESEND_SELF_ASSESSMENT_INVITATION)) {

            $popupHtml = EmployeeCompetencePageBuilder::getResendAssessmentInvitationPopupHtml( self::DIALOG_WIDTH,
                                                                                                self::ASSESSMENT_CONTENT_HEIGHT,
                                                                                                $employeeId,
                                                                                                $hashId);
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::ASSESSMENT_CONTENT_HEIGHT);
        }
    }
    static function finishResendSelfAssessmentInvitation($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView($objResponse, $employeeId);
    }

    static function displayHistoryAssessment($objResponse, $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {

            $popupHtml = EmployeeCompetencePageBuilder::getHistoryAssessmentPopupHtml(  self::DIALOG_WIDTH,
                                                                                        self::HISTORY_CONTENT_HEIGHT,
                                                                                        $employeeId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

    static function displayAddAssessmentEvaluation($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {

            list($popupHtml, $showUpload) = EmployeeCompetencePageBuilder::getAddAssessmentEvaluationPopupHtml( self::DIALOG_WIDTH,
                                                                                                                self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT,
                                                                                                                self::ASSESSMENT_EVALUATION_UPLOAD_HEIGHT,
                                                                                                                $employeeId);

            $editDialogHeight = self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT + ($showUpload ? self::ASSESSMENT_EVALUATION_UPLOAD_HEIGHT : 0);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            $editDialogHeight);
        }
    }

    static function displayEditAssessmentEvaluation($objResponse, $employeeId, $assessmentEvaluationId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {

            EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

            list($popupHtml, $showUpload) = EmployeeCompetencePageBuilder::getEditAssessmentEvaluationPopupHtml(self::DIALOG_WIDTH,
                                                                                                                self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT,
                                                                                                                self::ASSESSMENT_EVALUATION_UPLOAD_HEIGHT,
                                                                                                                $employeeId,
                                                                                                                $assessmentEvaluationId);

            $editDialogHeight = self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT + ($showUpload ? self::ASSESSMENT_EVALUATION_UPLOAD_HEIGHT : 0);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            $editDialogHeight);
        }
    }

    static function finishEditAssessmentEvaluation($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // refresh medewerkerslijst
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);

        self::displayView($objResponse, $employeeId);
    }

    // letop: beetje een uitzondering...
    static function cancelEditAssessmentEvaluation($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {
            // TODO: refactor deze functie. naar controller?
            $employeeDocumentId = EmployeeAssessmentEvaluationService::retrieveUploadedEvaluationDocumentId();
            if (!empty($employeeDocumentId)) {
                EmployeeDocumentService::removeDocument($employeeId, $employeeDocumentId);
            }
        }
        EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

        self::displayView($objResponse, $employeeId);
    }

    static function displayHistoryAssessmentEvaluation($objResponse, $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $valueObjects = EmployeeAssessmentEvaluationService::getValueObjects($employeeId);
            $popupHtml = EmployeeCompetencePageBuilder::getHistoryAssessmentEvaluationPopupHtml(    self::HISTORY_WIDTH,
                                                                                                    self::HISTORY_CONTENT_HEIGHT,
                                                                                                    $employeeId,
                                                                                                    $valueObjects);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

    static function displayRemoveAssessmentEvaluation($objResponse, $employeeId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {
            $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();
            $valueObject = EmployeeAssessmentEvaluationService::getValueObject($employeeId, $currentAssessmentCycle);


            $popupHtml = EmployeeCompetencePageBuilder::getRemoveAssessmentEvaluationPopupHtml( self::DIALOG_WIDTH,
                                                                                                self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT,
                                                                                                $employeeId ,
                                                                                                $valueObject);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::ASSESSMENT_EVALUATION_CONTENT_HEIGHT);
        }
    }

    static function finishRemove($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // refresh medewerkerslijst
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);

        self::displayView($objResponse, $employeeId);
    }

    static function displayEditJobProfile($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {

            $popupHtml = EmployeeCompetencePageBuilder::getEditJobProfilePopupHtml( self::DIALOG_WIDTH,
                                                                                    self::FUNCTION_CONTENT_HEIGHT,
                                                                                    $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::FUNCTION_CONTENT_HEIGHT);
        }
    }

    static function finishEditFunction($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // refresh medewerkerslijst
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);

        self::displayView($objResponse, $employeeId);
    }

    static function displayHistoryJobProfile($objResponse, $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {

            $popupHtml = EmployeeCompetencePageBuilder::getHistoryJobProfilePopupHtml(  self::HISTORY_WIDTH,
                                                                                        self::HISTORY_CONTENT_HEIGHT,
                                                                                        $employeeId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

}

?>
