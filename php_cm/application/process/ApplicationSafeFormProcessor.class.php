<?php

require_once('gino/MessageLogger.class.php');
require_once('application/library/safeFormConsts.inc.php');
require_once('application/library/safeDirectConsts.inc.php');
require_once('application/library/SafeFormHandler.class.php');

// process_moduleSafeForm
// application
require_once('application/process/user/PasswordSafeFormProcessor.class.php');
require_once('application/process/user/UserLevelSwitchSafeFormProcessor.class.php');
// modules
require_once('modules/process/library/AssessmentCycleSafeFormProcessor.class.php');
require_once('modules/process/library/QuestionSafeFormProcessor.class.php');
require_once('modules/process/library/DocumentClusterSafeFormProcessor.class.php');
require_once('modules/process/library/PdpActionSafeFormProcessor.class.php');
require_once('modules/process/assessmentProcess/AssessmentActionSafeFormProcessor.class.php');
require_once('modules/process/employee/finalResult/EmployeeFinalResultSafeFormProcessor.class.php');
require_once('modules/process/list/EmployeeListSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeAnswerSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeAssessmentSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeAssessmentEvaluationSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeScoreSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeJobProfileSafeFormProcessor.class.php');
require_once('modules/process/employee/document/EmployeeDocumentSafeFormProcessor.class.php');
require_once('modules/process/employee/pdpAction/EmployeePdpActionSafeFormProcessor.class.php');
require_once('modules/process/employee/profile/EmployeeProfilePersonalSafeFormProcessor.class.php');
require_once('modules/process/employee/profile/EmployeeProfileOrganisationSafeFormProcessor.class.php');
require_once('modules/process/employee/profile/EmployeeProfileInformationSafeFormProcessor.class.php');
require_once('modules/process/employee/profile/EmployeeProfileUserSafeFormProcessor.class.php');
require_once('modules/process/employee/target/EmployeeTargetSafeFormProcessor.class.php');
require_once('modules/process/employee/competence/EmployeeCompetenceSafeFormProcessor.class.php');
require_once('modules/process/batch/EmployeeTargetBatchSafeFormProcessor.class.php');
require_once('modules/process/batch/EmployeeSelfAssessmentBatchSafeFormProcessor.class.php');
require_once('modules/process/organisation/OrganisationInfoSafeFormProcessor.class.php');
require_once('modules/process/organisation/DepartmentSafeFormProcessor.class.php');
require_once('modules/process/settings/StandardDateSafeFormProcessor.class.php');
require_once('modules/process/report/TalentSelectorSafeFormProcessor.class.php');
require_once('modules/process/report/BaseReportEmployeeSafeFormProcessor.class.php');
require_once('modules/process/employee/print/EmployeePrintSafeFormProcessor.class.php');

// process_filterSafeForm
require_once('modules/process/list/EmployeeFilterSafeFormProcessor.class.php');


class ApplicationSafeFormProcessor {

    // Aplication methods

    static function logSafeFormDebugError($objResponse, $formIdentifier, $safeFormHandler, $message)
    {
        $errorLog = $formIdentifier . ' >> ' . $message;
        if (is_object($safeFormHandler)) {
            $errorLog .= $safeFormHandler->getErrorMessage();

            $errorStack  = 'Invalid form' . "\n\n";
            $errorStack .= 'Error: ' . $safeFormHandler->getErrorText() . "\n\n";
            $errorStack .= 'Input formats: ' . print_r($safeFormHandler->getInputFormats(), true) . "\n\n";
            $errorStack .= 'Clean values:  ' . print_r($safeFormHandler->retrieveCleanedValues(), true) . "\n\n";
            $errorStack .= 'Form values:   ' . print_r($raw_request_form, true) . "\n\n";
            $errorStack .= 'Trace:' . print_r(debug_backtrace(), true) . "\n\n";

        } else {
            $errorLog .= '$safeFormHandler is not an object';

            $errorStack  = $errorLog . "\n\n";
            $errorStack .= 'Trace:' . print_r(debug_backtrace(), true) . "\n\n";
        }
        MessageLogger::logError($errorLog, debug_backtrace());

        if (XAJAX_DEBUG_SETTING) {
            InterfaceXajax::alertMessage($objResponse, $errorStack);
        }
    }

    static function process_moduleSafeForm( xajaxResponse $objResponse,
                                            $formIdentifier,
                                            SafeFormHandler $safeFormHandler,
                                            $inPopup)
    {
        $hasError = false;
        $message = '';
        $enable_button = true;
        $enable_button_oldstyle = false;

        try {
            switch ($formIdentifier) {

                case SAFEFORM_ORGANISATION__PDPACTIONS_ADD_BATCH:
                    list($hasError, $message) = organisation__processSafeForm_addPdpActionsBatch($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_ORGANISATION__ATTACHMENT_ADD_BATCH:
                    list($hasError, $message) = organisation__processSafeForm_addAttachmentBatch($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_COMPETENCES__ADD_CLUSTER_DEPRECATED:
                    list($hasError, $message) = competences_processSafeForm_AddCluster_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_COMPETENCES__EDIT_CLUSTER_DEPRECATED:
                    list($hasError, $message) = competences_processSafeForm_editCluster_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_COMPETENCES__ADD_COMPETENCE_DEPRECATED:
                    list($hasError, $message) = competences_processSafeForm_addCompetence_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_COMPETENCES__EDIT_COMPETENCE_DEPRECATED:
                    list($hasError, $message) = competences_processSafeForm_editCompetence_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_FUNCTIONS__ADD_FUNCTION_DEPRECATED:
                    list($hasError, $message) = functions_processSafeForm_addFunction_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_FUNCTIONS__EDIT_FUNCTIONCOMPETENCE_DEPRECATED:
                    list($hasError, $message) = functions_processSafeForm_editFunctionCompetence_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_PDPACTIONLIBRARY__ADD_PDPACTION:
                    list($hasError, $message) = PdpActionSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_PDPACTIONLIBRARY__EDIT_PDPACTION:
                    list($hasError, $message) = PdpActionSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_PDPACTIONLIBRARY__DELETE_PDPACTION:
                    list($hasError, $message) = PdpActionSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_PDPACTIONLIBRARY__EDIT_PDPCLUSTER:
                    list($hasError, $message) = PdpActionSafeFormProcessor::processEditCluster($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_PDPACTIONLIBRARY__DELETE_PDPCLUSTER:
                    list($hasError, $message) = PdpActionSafeFormProcessor::processRemoveCluster($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__ADD_EMPLOYEE_DEPRECATED:
                    list($hasError, $message) = employees_processSafeForm_addEmployee_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_TOTALSCORE:
                    list($hasError, $message) = employees_processSafeForm_editTotalscore($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_SCORE_DEPRECATED:
                    list($hasError, $message) = employees_processSafeForm_editScore_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_ATTACHMENT_DEPRECATED:
                    list($hasError, $message) = EmployeeDocumentSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__DELETE_ATTACHMENT_DEPRECATED:
                    list($hasError, $message) = EmployeeDocumentSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__UPLOAD_ATTACHMENT_DEPRECATED:
                    list($hasError, $message) = EmployeeDocumentSafeFormProcessor::processUpload($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__ADD_TARGET_EVALUATION_PERIOD:
                    list($hasError, $message) = employees_processSafeForm_addTargetsEvaluationPeriod($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_TARGET_EVALUATION_PERIOD:
                    list($hasError, $message) = employees_processSafeForm_editTargetsEvaluationPeriod($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__ADD_EVALUATIONPERIOD_TARGET:
                    list($hasError, $message) = employees_processSafeForm_addTargetsEvaluationPeriodTarget($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_EVALUATIONPERIOD_TARGET:
                    list($hasError, $message) = employees_processSafeForm_editTargetsEvaluationPeriodTarget($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEES__ADD_EVALUATIONPERIOD_TARGET_EVALUATION:
                    list($hasError, $message) = employees_processSafeForm_addTargetsEvaluationPeriodTargetEvaluation($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_USERS__EDIT_USER:
                    list($hasError, $message) = users_processSafeForm_editUser($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_USERS__EDIT_PASSWORD_POPUP:
                    list($hasError, $message) = PasswordSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;

                // TODO: eigenlijk een actionSafeForm
                case SAFEFORM_USERS__SWITCH_USER_LEVEL_POPUP:
                    list($hasError, $message) = UserLevelSwitchSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_OPTIONS__EDIT_SCALEVALUES:
                    list($hasError, $message) = options_processSafeForm_editScaleValues($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_OPTIONS__EDIT_THEMECOLOUR:
                   list($hasError, $message) = options_processSafeForm_editThemeColour($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_OPTIONS__EDIT_THEMELANGUAGE:
                    list($hasError, $message) = options_processSafeForm_editThemeLanguage($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_FUNCTIONS__SELECT_BENCHMARK_DEPRECATED:
                    list($hasError, $message) = functions_processSafeForm_selectBenchmark_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_FUNCTIONS__EDIT_BENCHMARK_DEPRECATED:
                    list($hasError, $message) = functions_processSafeForm_editBenchmark_deprecated($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_LEVELAUTH__EDIT_ACCESS:
                    list($hasError, $message) = levelAuth_processSafeForm_editAccess($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_EMAILS__EDIT_EXTERNALEMAILADDRESS:
                    list($hasError, $message) = emails_processSafeForm_editExternalEmailAddress($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_EMAILS__EDIT_NOTIFICATIONMESSAGES:
                    list($hasError, $message) = emails_processSafeForm_editNotificationMessages($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_EMAILS__EDIT_NOTIFICATION360MESSAGE:
                    list($hasError, $message) = emails_processSafeForm_editNotification360Message($objResponse, $safeFormHandler);
                    $enable_button_oldstyle = true;
                    break;
                case SAFEFORM_EMPLOYEES__SHOW_TARGETPERIODSTATUSCHANGE:
                    // Wat doen we met deze?
                    break;
                case SAFEFORM_EMPLOYEES__EDIT_TARGETPERIODSTATUSCHANGE:
                    $hasError = employees_processSafeForm_editTargetPeriodStatusChange($objResponse, $safeFormHandler);
                    $enable_button = false; // want inline
                    break;

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // new style stuff
                case SAFEFORM_ASSESSMENT_LIBRARY__ADD_QUESTION:
                    list($hasError, $message) = QuestionSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ASSESSMENT_LIBRARY__EDIT_QUESTION:
                    list($hasError, $message) = QuestionSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ASSESSMENT_LIBRARY__DELETE_QUESTION:
                    list($hasError, $message) = QuestionSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_ASSESSMENT_LIBRARY__ADD_ASSESSMENT_CYCLE:
                    list($hasError, $message) = AssessmentCycleSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ASSESSMENT_LIBRARY__EDIT_ASSESSMENT_CYCLE:
                    list($hasError, $message) = AssessmentCycleSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ASSESSMENT_LIBRARY__DELETE_ASSESSMENT_CYCLE:
                    list($hasError, $message) = AssessmentCycleSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_DOCUMENTCLUSTERS__ADD_DOCUMENTCLUSTER:
                    list($hasError, $message) = DocumentClusterSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_DOCUMENTCLUSTERS__EDIT_DOCUMENTCLUSTER:
                    list($hasError, $message) = DocumentClusterSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_DOCUMENTCLUSTERS__DELETE_DOCUMENTCLUSTER:
                    list($hasError, $message) = DocumentClusterSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__EDIT_FINAL_RESULT:
                    list($hasError, $message) = EmployeeFinalResultSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__ADD_PDP_ACTION:
                    list($hasError, $message) = EmployeePdpActionSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_PDP_ACTION:
                    list($hasError, $message) = EmployeePdpActionSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__DELETE_PDP_ACTION:
                    list($hasError, $message) = EmployeePdpActionSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_PDP_ACTION_USER_DEFINED:
                    list($hasError, $message) = EmployeePdpActionSafeFormProcessor::processEditUserDefined($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__EDIT_PROFILE_PERSONAL:
                    list($hasError, $message) = EmployeeProfilePersonalSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__DELETE_PROFILE_PERSONAL_PHOTO:
                    list($hasError, $message) = EmployeeProfilePersonalSafeFormProcessor::processRemovePhoto($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_PROFILE_PERSONAL_PHOTO:
                    list($hasError, $message) = EmployeeProfilePersonalSafeFormProcessor::processEditPhoto($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_PROFILE_ORGANISATION:
                    list($hasError, $message) = EmployeeProfileOrganisationSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__ADD_PROFILE_USER:
                    list($hasError, $message) = EmployeeProfileUserSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_PROFILE_INFORMATION:
                    list($hasError, $message) = EmployeeProfileInformationSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__DELETE_PROFILE:
                    list($hasError, $message) = EmployeeListSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__ADD_EMPLOYEE_TARGET:
                    list($hasError, $message) = EmployeeTargetSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_EMPLOYEE_TARGET:
                    list($hasError, $message) = EmployeeTargetSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__DELETE_EMPLOYEE_TARGET:
                    list($hasError, $message) = EmployeeTargetSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_EMPLOYEE_TARGET_STATUS:
                    list($hasError, $message) = EmployeeTargetSafeFormProcessor::processEditStatus($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__PRINT_EMPLOYEE_TARGET:
                    list($hasError, $message) = EmployeeTargetSafeFormProcessor::processPrintOptions($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__PRINT:
                    list($hasError, $message) = EmployeePrintSafeFormProcessor::processPrintOptions($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_EMPLOYEE__EDIT_QUESTIONS_ANSWER:
                    list($hasError, $message) = EmployeeAnswerSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_BULK_SCORE:
                    list($hasError, $message) = EmployeeScoreSafeFormProcessor::processBulkEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_CLUSTER_SCORE:
                    list($hasError, $message) = EmployeeScoreSafeFormProcessor::processClusterEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT:
                    list($hasError, $message) = EmployeeAssessmentSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__RESEND_SELF_ASSESSEMENT_INVITATION:
                    list($hasError, $message) = EmployeeAssessmentSafeFormProcessor::processResend($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT_EVALUATION:
                    list($hasError, $message) = EmployeeAssessmentEvaluationSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__DELETE_ASSESSEMENT_EVALUATION:
                    list($hasError, $message) = EmployeeAssessmentEvaluationSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__EDIT_FUNCTION:
                    list($hasError, $message) = EmployeeJobProfileSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_EMPLOYEE__PRINT_COMPETENCES:
                    list($hasError, $message) = EmployeeCompetenceSafeFormProcessor::processPrint($objResponse, $safeFormHandler);
                    break;

                // organisation
                case SAFEFORM_ORGANISATION__EDIT_ORGANISATION_INFO:
                    list($hasError, $message) = OrganisationInfoSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ORGANISATION__ADD_DEPARTMENT:
                    list($hasError, $message) = DepartmentSafeFormProcessor::processAdd($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ORGANISATION__EDIT_DEPARTMENT:
                    list($hasError, $message) = DepartmentSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_ORGANISATION__DELETE_DEPARTMENT:
                    list($hasError, $message) = DepartmentSafeFormProcessor::processRemove($objResponse, $safeFormHandler);
                    break;

                // report
                case SAFEFORM_REPORT__EXECUTE_TALENT_SELECTOR:
                    list($hasError, $message) = TalentSelectorSafeFormProcessor::processExecute($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_REPORT__PRINT_TALENT_SELECTOR:
                    list($hasError, $message) = TalentSelectorSafeFormProcessor::processPrint($objResponse, $safeFormHandler);
                    break;

                case SAFEFORM_REPORT__INLINE_ASSESSMENT_CYCLE_SELECTOR:
                    list($hasError, $message) = BaseReportSafeFormProcessor::processSelector($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_REPORT__EDIT_REPORT_PERIOD_DATES:
                    list($hasError, $message) = BaseReportSafeFormProcessor::processPeriodDatesEdit($objResponse, $safeFormHandler);
                    break;

                // batch
                case SAFEFORM_BATCH__ADD_TARGET:
                    list($hasError, $message) = EmployeeTargetBatchSafeFormProcessor::processAddBatch($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_BATCH__ADD_INVITATION_SELF_ASSESSMENT:
                    list($hasError, $message) = EmployeeSelfAssessmentBatchSafeFormProcessor::processInviteBatch($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_BATCH__REMINDER_SELF_ASSESSMENT:
                    list($hasError, $message) = EmployeeSelfAssessmentBatchSafeFormProcessor::processRemindBatch($objResponse, $safeFormHandler);
                    break;

                // action
                case SAFEFORM_EMPLOYEE__VERIFY_ACTION:
                    list($hasError, $message) = AssessmentActionSafeFormProcessor::processAction($objResponse, $safeFormHandler);
                    break;

                // settings
                case SAFEFORM_ORGANISATION__EDIT_STANDARD_DATE:
                    list($hasError, $message) = StandardDateSafeFormProcessor::processEdit($objResponse, $safeFormHandler);
                    break;

                default:
                    $hasError = true;
                    $message  = 'unhandled form request';
                    TimecodeException::raise($message, PamExceptionCodeValue::SAFEFORM_FORM_REQUEST);
            }
            if ($hasError) {
                if (!empty($message)) {
                    if ($inPopup) {
                        if (is_array($message)) {
                            $messageHtml = ApplicationInterfaceBuilder::getMessagesHtml($message);
                        }
                        InterfaceXajax::showMessageDialog($objResponse, $messageHtml, MESSAGE_ERROR);
                    } else {
                        InterfaceXajax::alertMessage($objResponse, $message);
                    }
                }
                if ($enable_button) {
                    InterfaceXajax::enableButton($objResponse, PROCESS_BUTTON);
                }
            }
            if ($enable_button_oldstyle) {
                InterfaceXajax::enableButton($objResponse, PROCESS_BUTTON);
                if (!empty($message) && !$hasError && !$inPopup) {
                    InterfaceXajax::alertMessage($objResponse, $message);
                }

            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
        }

    }

    // Sysadmin method

    static function process_sysAdminSafeForm($objResponse, $formIdentifier, $safeFormHandler)
    {
        $hasError = false;
        $message = '';

        try {
            switch ($formIdentifier) {
                case SAFEFORM_CUSTOMERS__ADD_CUSTOMER:
                    list($hasError, $message) = customers_safeProcessAddCustomer($objResponse, $safeFormHandler);
                    break;
                case SAFEFORM_CUSTOMERS__EDIT_CUSTOMER:
                    list($hasError, $message) = customers_safeProcessEditCustomer($objResponse, $safeFormHandler);
                    break;
                default:
                    $hasError = true;
                    $message  = 'unhandled form request';
                    TimecodeException::raise($message, PamExceptionCodeValue::SAFEFORM_FORM_REQUEST);
            }
            if (!empty($message)) {
                InterfaceXajax::alertMessage($objResponse, $message);
            }
            InterfaceXajax::enableButton($objResponse, 'submitButton');

        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
        }
    }

    static function process_filterSafeForm($objResponse, $formIdentifier, $safeFilterHandler)
    {
        $hasError = false;
        $message = '';

        try {
            switch ($formIdentifier) {
                case SAFEFORM_EMPLOYEE__LIST_FILTER:
                    list($hasError, $message) = EmployeeFilterSafeFormProcessor::actionFilter($objResponse, $safeFilterHandler);
                    break;

                default:
                    $hasError = true;
                    $message  = 'unhandled filter request';
                    TimecodeException::raise($message, PamExceptionCodeValue::SAFEFORM_FORM_REQUEST);
            }
            if ($hasError) {
                if (!empty($message)) {
                    InterfaceXajax::alertMessage($objResponse, $message);
                }
            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
        }

    }

    static function process_actionSafeForm($objResponse, $formIdentifier, $safeActionHandler, $buttonId)
    {
        $hasError = false;
        $message = '';

        try {
            switch ($formIdentifier) {
                case SAFEFORM_EMPLOYEE__PROCESS_ACTION:
                    list($hasError, $message) = AssessmentActionSafeFormProcessor::processActionRequest($objResponse, $safeActionHandler, $buttonId);
                    break;

                default:
                    $hasError = true;
                    $message  = 'unhandled action request';
                    TimecodeException::raise($message, PamExceptionCodeValue::SAFEFORM_FORM_REQUEST);
            }
            if ($hasError) {
                if (!empty($message)) {
                    InterfaceXajax::alertMessage($objResponse, $message);
                }
            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, $message);
        }

    }

}

?>
