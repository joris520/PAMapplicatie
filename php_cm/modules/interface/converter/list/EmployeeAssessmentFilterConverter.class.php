<?php

/**
 * Description of EmployeeAssessmentFilterConverter
 *
 * @author ben.dokter
 */
require_once('application/interface/converter/AbstractBaseConverter.class.php');

class EmployeeAssessmentFilterConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeAssessmentFilterValue::INVITED:
                $display = TXT_UCF('FILTER_EMPLOYEES_INVITED_YES');
                break;
            case EmployeeAssessmentFilterValue::NOT_INVITED:
                $display = TXT_UCF('FILTER_EMPLOYEES_INVITED_NO');
                break;
            case EmployeeAssessmentFilterValue::INVITED_EMPLOYEE_NOT_FILLED_IN:
                $display = TXT_UCF('FILTER_EMPLOYEES_INVITED_YES_EMPLOYEE_FILLED_IN_NO');
                break;
            case EmployeeAssessmentFilterValue::INVITED_MANAGER_NOT_FILLED_IN:
                $display = TXT_UCF('FILTER_EMPLOYEES_INVITED_YES_EMPLOYEE_FILLED_IN_YES');
                break;
            case EmployeeAssessmentFilterValue::INVITED_BOTH_FILLED_IN:
                $display = TXT_UCF('FILTER_EMPLOYEES_INVITED_YES_MANAGER_FILLED_IN_YES');
                break;
            case EmployeeAssessmentFilterValue::TODO_EVALUATION:
                $display = TXT_UCF('FILTER_EMPLOYEES_EMPLOYEES_FOR_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::DONE_EVALUATION:
                $display = TXT_UCF('FILTER_EMPLOYEES_EMPLOYEES_AFTER_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::NO_EVALUATION:
                $display = TXT_UCF('FILTER_EMPLOYEES_EMPLOYEES_NO_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_NONE:
                $display = TXT_UCF('FILTER_EMPLOYEES_STATUS_MANAGER_NONE');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_PRELIMINARY:
                $display = TXT_UCF('FILTER_EMPLOYEES_STATUS_MANAGER_PRELIMINARY');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_FINAL:
                $display = TXT_UCF('FILTER_EMPLOYEES_STATUS_MANAGER_FINAL');
                break;
//            case EmployeeAssessmentFilterValue::INVITED_MANAGER_COMPLETED:
//                $display = TXT_UCF('');
//                break;
//            case EmployeeAssessmentFilterValue::INVITED_BOTH_FILLED_IN_NO_LOS:
//                $display = TXT_UCF('');
//                break;
//            case EmployeeAssessmentFilterValue::INVITED_NO_LOS:
//                $display = TXT_UCF('');
//                break;
        }
        return $display;
    }


    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

    static function description($value)
    {
        $description = '';
        switch($value) {
            case EmployeeAssessmentFilterValue::INVITED:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_INVITED_YES');
                break;
            case EmployeeAssessmentFilterValue::NOT_INVITED:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_INVITED_NO');
                break;
            case EmployeeAssessmentFilterValue::INVITED_EMPLOYEE_NOT_FILLED_IN:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_INVITED_YES_EMPLOYEE_FILLED_IN_NO');
                break;
            case EmployeeAssessmentFilterValue::INVITED_MANAGER_NOT_FILLED_IN:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_INVITED_YES_EMPLOYEE_FILLED_IN_YES');
                break;
            case EmployeeAssessmentFilterValue::INVITED_BOTH_FILLED_IN:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_INVITED_YES_MANAGER_FILLED_IN_YES');
                break;
            case EmployeeAssessmentFilterValue::TODO_EVALUATION:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_EMPLOYEES_FOR_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::DONE_EVALUATION:
                $description = TXT_UCF('FILTER_EMPLOYEES_TITLE_EMPLOYEES_AFTER_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::NO_EVALUATION:
                $display = TXT_UCF('FILTER_EMPLOYEES_TITLE_EMPLOYEES_NO_EVALUATION');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_NONE:
                $display = TXT_UCF('FILTER_EMPLOYEES_TITLE_STATUS_MANAGER_NONE');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_PRELIMINARY:
                $display = TXT_UCF('FILTER_EMPLOYEES_TITLE_STATUS_MANAGER_PRELIMINARY');
                break;
            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_FINAL:
                $display = TXT_UCF('FILTER_EMPLOYEES_TITLE_STATUS_MANAGER_FINAL');
                break;
//            case EmployeeAssessmentFilterValue::INVITED_MANAGER_COMPLETED:
//                $display = TXT_UCF('');
//                break;
//            case EmployeeAssessmentFilterValue::INVITED_BOTH_FILLED_IN_NO_LOS:
//                $display = TXT_UCF('');
//                break;
//            case EmployeeAssessmentFilterValue::INVITED_NO_LOS:
//                $display = TXT_UCF('');
//                break;
        }

        return $description;
    }

}

?>
