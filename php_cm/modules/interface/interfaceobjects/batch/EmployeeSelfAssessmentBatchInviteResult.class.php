<?php

/**
 * Description of EmployeeSelfAssessmentBatchInviteResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeSelfAssessmentBatchInviteResult extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeSelfAssessmentBatchInviteResult.tpl';

    private $showDetails;

    static function createWithValueObject(EmployeeSelfAssessmentBatchValueObject $valueObject,
                                          $displayWidth)
    {
        return new EmployeeSelfAssessmentBatchInviteResult( $valueObject,
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
