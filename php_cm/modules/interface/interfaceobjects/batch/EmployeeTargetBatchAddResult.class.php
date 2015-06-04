<?php


/**
 * Description of EmployeeTargetBatchAddResult
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeTargetBatchAddResult extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeTargetBatchAddResult.tpl';

    private $targetName;
    private $employeeCount;

    static function create($displayWidth)
    {
        return new EmployeeTargetBatchAddResult($displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeCount
    function setEmployeeCount($employeeCount)
    {
        $this->employeeCount = $employeeCount;
    }

    function getEmployeeCount()
    {
        return $this->employeeCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $targetName
    function setTargetName($targetName)
    {
        $this->targetName = $targetName;
    }

    function getTargetName()
    {
        return $this->targetName;
    }


}

?>
