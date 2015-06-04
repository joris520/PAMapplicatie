<?php

/**
 * Description of EmployeeListState
 *
 * @author ben.dokter
 */


class EmployeeListState
{
    const LIST_EMPLOYEES            = 1;      // normale lijst met medewerkers
    const SCORE_STATUS_ONLY         = 2;      // de score status in een icoontje ervoor
    const SELF_ASSESSMENT_NORMAL    = 3;      // de score status en invul status medewerker icoontjes
    const SELF_ASSESSMENT_PROCESS   = 4;      // ook de checkboxes en functioneringsgesprekken icoontjes


    static function determineState()
    {
        $employeeListState = self::LIST_EMPLOYEES;
        if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
            if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                $employeeListState = self::SELF_ASSESSMENT_PROCESS;
            } else {
                $employeeListState = self::SELF_ASSESSMENT_NORMAL;
            }
        } else {
            if (CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS &&
                PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE)) { // wel score icoontjes, geen zelfevaluatie
                $employeeListState = self::SCORE_STATUS_ONLY;
            }
        }
        return $employeeListState;
    }

    static function debugInfo($state)
    {
        $debugInfo = '';
        switch($state) {
            case self::LIST_EMPLOYEES:
                $debugInfo .= 'list_employees';
                break;
            case self::SCORE_STATUS_ONLY:
                $debugInfo .= 'score_status_only';
                break;
            case self::SELF_ASSESSMENT_NORMAL:
                $debugInfo .= 'self_assessment_normal';
                break;
            case self::SELF_ASSESSMENT_PROCESS:
                $debugInfo .= 'self_assessment_process';
                break;
            default:
                $debugInfo .= 'empty';
        }
        return $debugInfo;
    }

}

?>
