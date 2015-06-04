<?php

/**
 * Description of EmployeeCompetencePageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/interface/builder/library/AssessmentCycleInterfaceBuilder.class.php');

require_once('modules/interface/builder/employee/competence/EmployeeJobProfileInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/competence/EmployeeAssessmentInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/competence/EmployeeAssessmentEvaluationInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/competence/EmployeeScoreInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/competence/EmployeeAnswerInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/competence/EmployeeCompetenceInterfaceBuilder.class.php');

require_once('modules/interface/interfaceobjects/assessmentInvitation/AssessmentIconCollection.class.php');

class EmployeeCompetencePageBuilder
{
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject,
                                EmployeeCompetenceCollection $employeeCompetenceCollection,
                                EmployeeAssessmentProcessValueObject $assessmentProcessValueObject,
                                $hiliteClusterId = NULL)
    {
        $assessmentIconViewCollection           = AssessmentIconCollection::create($employeeCompetenceCollection->getAssessmentCollection());
        $previousAssessmentIconViewCollection   = AssessmentIconCollection::create($employeeCompetenceCollection->getPreviousAssessmentCollection());


        list($hasAssessmentEvaluation, $assessmentEvaluationHtml) =
                                EmployeeAssessmentEvaluationInterfaceBuilder::getViewHtml(  $displayWidth,
                                                                                            $employeeId,
                                                                                            $employeeCompetenceCollection->getEmployeeAssessmentEvaluationValueObject(),
                                                                                            $assessmentProcessValueObject,
                                                                                            EmployeeAssessmentEvaluationInterfaceBuilder::VIEW_AS_SUBBLOCK);

        // de onderdelen van de pagina opbouwen
        return  EmployeeCompetenceInterfaceBuilder::getEmployeeInfoHeaderHtml(  $displayWidth,
                                                                                $employeeId,
                                                                                $employeeInfoValueObject,
                                                                                $employeeCompetenceCollection->getEmployeeJobProfileValueObject()) .
                EmployeeAssessmentInterfaceBuilder::getViewHtml($displayWidth,
                                                                $employeeId,
                                                                $employeeCompetenceCollection->getEmployeeAssessmentValueObject(),
                                                                $employeeCompetenceCollection->getAssessmentCollection(),
                                                                !$hasAssessmentEvaluation) .
                $assessmentEvaluationHtml .
                EmployeeScoreInterfaceBuilder::getViewHtml( $displayWidth,
                                                            $employeeId,
                                                            $hiliteClusterId,
                                                            $employeeCompetenceCollection->getCurrentEmployeeCompetenceCategoryClusterScoreCollection(),
                                                            $employeeCompetenceCollection->getPreviousEmployeeCompetenceCategoryClusterScoreCollection(),
                                                            $assessmentIconViewCollection,
                                                            $previousAssessmentIconViewCollection) .
                EmployeeAnswerInterfaceBuilder::getViewHtml($displayWidth,
                                                            $employeeId,
                                                            $employeeCompetenceCollection->getEmployeeAnswerCollection());
    }

    // competence scores
    static function getEditBulkScorePopupHtml(  $displayWidth,
                                                $contentHeight,
                                                $employeeId,
                                                EmployeeCompetenceCategoryClusterScoreCollection $employeeCompetenceScoreCollection)
    {
        list($safeFormHandler, $contentHtml) = EmployeeScoreInterfaceBuilder::getEditBulkHtml($displayWidth, $employeeId, $employeeCompetenceScoreCollection);

        // popup
        $formId = 'edit_bulk_competence_score_form_' . $employeeId;
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('SCORE');
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }

    // competence scores
    static function getEditClusterScorePopupHtml(   $displayWidth,
                                                    $contentHeight,
                                                    $employeeId,
                                                    EmployeeCompetenceClusterScoreCollection $clusterScoreCollection)
    {
        list($safeFormHandler, $contentHtml, $clusterName) = EmployeeScoreInterfaceBuilder::getEditClusterHtml( $displayWidth,
                                                                                                                $employeeId,
                                                                                                                $clusterScoreCollection);

        // popup
        $formId = 'edit_cluster_competence_score_form_' . $employeeId;
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('SCORE') . ': ' . $clusterName;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getHistoryScorePopupHtml($displayWidth, $contentHeight, $employeeId, $competenceId)
    {
        // ophalen competentie info
        $competenceValueObject = CompetenceService::getValueObjectById($competenceId);

        $contentHtml = EmployeeScoreInterfaceBuilder::getHistoryHtml($displayWidth, $employeeId, $competenceValueObject);

        // popup
        $title = TXT_UCF('HISTORY') . ': ' . $competenceValueObject->competenceName;
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    // assessment question answers
    static function getEditAnswerPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();
        list($safeFormHandler, $contentHtml) = EmployeeAnswerInterfaceBuilder::getEditHtml($displayWidth, $employeeId, $currentAssessmentCycle);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('ASSESSMENT_QUESTIONS');
        $formId = 'edit_answers_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }
    static function getHistoryQuestionAnswerPopupHtml($displayWidth, $contentHeight, $employeeId, $questionId)
    {
        $contentHtml = EmployeeAnswerInterfaceBuilder::getHistoryHtml($displayWidth, $employeeId, $questionId);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_UCF('ASSESSMENT_QUESTION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    // assessment
    static function getAddAssessmentPopupHtml($displayWidth, $contentHeight, $employeeId, EmployeeAssessmentValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = EmployeeAssessmentInterfaceBuilder::getEditHtml($displayWidth, $employeeId, $valueObject);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('ASSESSMENT');
        $formId = 'add_assessment_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getEditAssessmentPopupHtml($displayWidth, $contentHeight, $employeeId, EmployeeAssessmentValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = EmployeeAssessmentInterfaceBuilder::getEditHtml($displayWidth, $employeeId, $valueObject);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_UCF('ASSESSMENT');
        $formId = 'edit_assessment_form_' . $employeeId . '_' . $assessmentId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getHistoryAssessmentPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        $contentHtml = EmployeeAssessmentInterfaceBuilder::getHistoryHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_UCF('ASSESSMENT');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getResendAssessmentInvitationPopupHtml($displayWidth, $contentHeight, $employeeId, $hashId)
    {
        $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
        list($safeFormHandler, $contentHtml) = EmployeeAssessmentInterfaceBuilder::getResendAssessmentInvitationHtml($displayWidth, $employeeId, $hashId, $currentPeriod);

        // popup
        $title = TXT_UCF('RESEND_SELF_ASSESSMENT_INVITATION');
        $formId = 'resend_invitation_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getActionPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    // assessment evaluation
    static function getAddAssessmentEvaluationPopupHtml($displayWidth, $contentHeight, $uploadHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml, $showUpload) = EmployeeAssessmentEvaluationInterfaceBuilder::getAddHtml($displayWidth, $employeeId);

        // popup
        if ($showUpload) {
            $contentHeight += $uploadHeight;
        }
        $title = TXT_UCF('MARK_ASSESSMENT_EVALUATION_DONE');
        $formId = 'add_assessment_evaluation_form_' . $employeeId;
        $popupHtml = ApplicationInterfaceBuilder::getEditPopupHtml( $formId,
                                                                    $safeFormHandler,
                                                                    $title,
                                                                    $contentHtml,
                                                                    $displayWidth,
                                                                    $contentHeight,
                                                                    ApplicationInterfaceBuilder::SHOW_WARNING,
                                                                    NULL,
                                                                    'xajax_public_employeeCompetence__cancelEditAssessmentEvaluation('. $employeeId . ')');
        return array($popupHtml, $showUpload);
    }

    static function getEditAssessmentEvaluationPopupHtml($displayWidth, $contentHeight, $uploadHeight, $employeeId, $assessmentEvaluationId)
    {
        list($safeFormHandler, $contentHtml, $showUpload) = EmployeeAssessmentEvaluationInterfaceBuilder::getEditHtml($displayWidth, $employeeId, $assessmentEvaluationId);

        // popup
        if ($showUpload) {
            $contentHeight += $uploadHeight;
        }
        $title = TXT_UCF('MARK_ASSESSMENT_EVALUATION_DONE');
        $formId = 'edit_assessment_evaluation_form_' . $employeeId;
        $popupHtml = ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::SHOW_WARNING, TXT_BTN('SAVE'));
        return array($popupHtml, $showUpload);

    }

    static function getHistoryAssessmentEvaluationPopupHtml($displayWidth,
                                                            $contentHeight,
                                                            $employeeId,
                                                            Array /* EmployeeAssessmentEvaluationValueObject */ $valueObjects)
    {
        $contentHtml = EmployeeAssessmentEvaluationInterfaceBuilder::getHistoryHtml($displayWidth,
                                                                                    $employeeId,
                                                                                    $valueObjects);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_LC('ASSESSMENT_EVALUATION');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

    static function getRemoveAssessmentEvaluationPopupHtml( $displayWidth,
                                                            $contentHeight,
                                                            $employeeId,
                                                            EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        list($safeFormHandler, $contentHtml) = EmployeeAssessmentEvaluationInterfaceBuilder::getRemoveHtml($displayWidth, $employeeId, $valueObject);

        // popup
        $title = TXT_UCF('DELETE') . ' ' . TXT_LC('ASSESSMENT_CYCLE');
        $formId = 'delete_assessment_evaluation_form_' . $employeeId . '_' . $assessmentEvaluationId;
        return ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }


    static function getEditJobProfilePopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeJobProfileInterfaceBuilder::getEditHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('JOB_PROFILE');
        $formId = 'edit_function_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }


    static function getHistoryJobProfilePopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        $contentHtml = EmployeeJobProfileInterfaceBuilder::getHistoryHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('HISTORY') . ' ' . TXT_LC('JOB_PROFILE');
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

}

?>
