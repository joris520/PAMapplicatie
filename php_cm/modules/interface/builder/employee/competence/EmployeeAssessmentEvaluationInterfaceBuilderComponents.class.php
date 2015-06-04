<?php

/**
 * Description of EmployeeAssessmentEvaluationInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeAssessmentEvaluationInterfaceBuilderComponents
{
    static function getAddLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {
            $html .= InterfaceBuilder::iconLink('add_employee_assessment_evaluation_' . $employeeId ,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_EVALUATION'),
                                                'xajax_public_employeeCompetence__addAssessmentEvaluation(' . $employeeId . ');',
                                                ICON_EDIT); // dit hoort zo
        }
        return $html;
    }

    static function getEditLink($employeeId, $assessmentEvaluationId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_assessment_evaluation_' . $employeeId . '_' . $assessmentEvaluationId ,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_EVALUATION'),
                                                'xajax_public_employeeCompetence__editAssessmentEvaluation(' . $employeeId . ', ' . $assessmentEvaluationId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink($employeeId, $assessmentEvaluationId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE) &&
            !empty($assessmentEvaluationId)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_assessment_evaluation_' . $employeeId . '_' . $assessmentEvaluationId ,
                                                TXT_UCF('DELETE') . ' ' . TXT_LC('ASSESSMENT_EVALUATION'),
                                                'xajax_public_employeeCompetence__removeAssessmentEvaluation(' . $employeeId . ', ' . $assessmentEvaluationId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getHistoryLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $html .= InterfaceBuilder::iconLink('view_employee_assessment_evaluation_history_' . $employeeId ,
                                                TXT_UCF('HISTORY'),
                                                'xajax_public_employeeCompetence__displayHistoryAssessmentEvaluation(' . $employeeId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }

    static function getAttachmentLink($employeeId, $attachmentId)
    {
        $html = '';
        if (!empty($attachmentId)) {
            $attachmentLink = InterfaceBuilderComponents::getAttachmentLink($employeeId, $attachmentId);
            $html = empty($attachmentLink) ? TXT_LC('NO_ACCESS') : $attachmentLink;
        } else {
            $html = NULL;
        }
        return $html;
    }

}

?>
