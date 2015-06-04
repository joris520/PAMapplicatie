<?php

/**
 * Description of EmployeeSelfAssessmentBatchRemindResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeSelfAssessmentBatchRemindResult extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeSelfAssessmentBatchRemindResult.tpl';

    private $showDetails;

    static function createWithValueObject(EmployeeSelfAssessmentBatchValueObject $valueObject,
                                          $displayWidth)
    {
        return new EmployeeSelfAssessmentBatchRemindResult( $valueObject,
                                                            $displayWidth,
                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowDetails($showDetails)
    {
        $this->showDetails = $showDetails;
    }

    function showDetails()
    {
        return $this->showDetails;
    }

}

?>
