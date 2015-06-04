<?php


/**
 * Description of EmployeeAnswerInterfaceBuilderComponents
 *
 * @author ben.dokter
 */


class EmployeeAnswerInterfaceBuilderComponents {


    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('edit_assessment_answers_' . $employeeId,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_QUESTIONS'),
                                                'xajax_public_employeeCompetence__editAssessmentQuestionsAnswer(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getHistoryLink($employeeId, $questionId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $html .= InterfaceBuilder::iconLink('history_assessment_answers_' . $employeeId . '_' . $questionId,
                                                TXT_UCF('HISTORY') . ' ' . TXT_LC('ASSESSMENT_QUESTION'),
                                                'xajax_public_employeeCompetence__displayHistoryQuestionAnswer(' . $employeeId . ' , ' . $questionId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }

}

?>
