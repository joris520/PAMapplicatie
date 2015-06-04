<?php

/**
 * Description of EmployeeAssessmentFilterValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class EmployeeAssessmentFilterValue extends BaseDatabaseValue
{
    // mode
    const MODE_EMPLOYEELIST                 =  1;
    const MODE_INVITATIONS                  =  2;

    // values
    // Filters voor medewerkerslijst

    // CUSTOMER_OPTION_USE_SELFASSESSMENT
    const ANY                               =  0;
    const INVITED                           =  1;
    const NOT_INVITED                       =  2;
    const INVITED_EMPLOYEE_NOT_FILLED_IN    =  3;
    const INVITED_MANAGER_NOT_FILLED_IN     =  4;
    const INVITED_BOTH_FILLED_IN            =  5;

    // CUSTOMER_OPTION_USE_SELFASSESSMENT &&
    // CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS
    const TODO_EVALUATION                   =  7;
    const DONE_EVALUATION                   =  8;
    const NO_EVALUATION                     =  9;

    // filter bij uitnodigen
    const INVITED_MANAGER_COMPLETED         = 10;
    const INVITED_BOTH_FILLED_IN_NO_LOS     = 11;
    const INVITED_NO_LOS                    = 12;

    const CHECK_ASSESSMENT_LAST             = 13; // last indicator

    // CUSTOMER_OPTION_USE_SCORE_STATUS
    const SCORE_STATUS_MANAGER_NONE         = 14;
    const SCORE_STATUS_MANAGER_PRELIMINARY  = 15;
    const SCORE_STATUS_MANAGER_FINAL        = 16;


    static function values($mode = self::MODE_EMPLOYEELIST)
    {
        $values = array();
        switch($mode) {
            case self::MODE_EMPLOYEELIST:
                if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
                    $values =   array(
                                    self::INVITED,
                                    self::NOT_INVITED,
                                    self::INVITED_EMPLOYEE_NOT_FILLED_IN,
                                    self::INVITED_MANAGER_NOT_FILLED_IN,
                                    self::INVITED_BOTH_FILLED_IN
                                );
                    if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                        $values[] = self::TODO_EVALUATION;
                        $values[] = self::DONE_EVALUATION;
                        $values[] = self::NO_EVALUATION;
                    }
                }
                if (CUSTOMER_OPTION_USE_SCORE_STATUS) {
                    $values[] = self::SCORE_STATUS_MANAGER_NONE;
                    $values[] = self::SCORE_STATUS_MANAGER_PRELIMINARY;
                    $values[] = self::SCORE_STATUS_MANAGER_FINAL;
                }
                break;
            case self::MODE_INVITATIONS:
                $values[] = self::INVITED_MANAGER_COMPLETED;
                $values[] = self::INVITED_BOTH_FILLED_IN_NO_LOS;
                $values[] = self::INVITED_NO_LOS;
                break;
        }
        return $values;
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
