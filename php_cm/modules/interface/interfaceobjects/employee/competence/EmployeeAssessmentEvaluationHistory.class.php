<?php

/**
 * Description of EmployeeAssessmentEvaluationHistory
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeAssessmentEvaluationHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentEvaluationHistory.tpl';

    static function create($displayWidth)
    {
        return new EmployeeAssessmentEvaluationHistory( $displayWidth,
                                                        self::TEMPLATE_FILE);
    }

    function addValueObject(EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
