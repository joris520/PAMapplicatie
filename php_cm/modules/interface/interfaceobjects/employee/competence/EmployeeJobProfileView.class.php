<?php

/**
 * Description of EmployeeJobProfileView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeJobProfileView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeJobProfileView.tpl';

    private $mainFunctionIdValue;
    private $additionalFunctionIdValues;
    private $additionalFunctionNames;

    static function createWithValueObject(  EmployeeJobProfileValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeJobProfileView(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getMainFunctionId()
    {
        return $this->mainFunctionIdValue->getDatabaseId();
    }

    function getMainFunctionName()
    {
        return $this->mainFunctionIdValue->getValue();
    }

    function getMainFunctionIdValue()
    {
        return $this->mainFunctionIdValue;
    }

    function getAdditionalFunctionIdValues()
    {
        return $this->additionalFunctionIdValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getFunctionIdValues()
    {
        return array_merge(array($this->mainFunctionIdValue), $this->additionalFunctionIdValues);
    }

    // afgeleide waarden
    function getFunctionIds()
    {
        return $this->allFunctionIds;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAdditionalFunctionIds()
    {
        return $this->additionalFunctionIds;
    }

    function getAdditionalFunctionNames()
    {
        return $this->additionalFunctionNames;
    }

    function getAdditionalFunctionsList()
    {
        $additionalFunctionValueObjects = $this->valueObject->getAdditionalFunctions();
        if (count($additionalFunctionValueObjects) > 0) {
            $additionalFunctionNames = array();
            foreach($additionalFunctionValueObjects as $additionalFunctionValueObject) {
                $additionalFunctionNames[] = $additionalFunctionValueObject->getFunctionName();
            }

            $additionalFunctionsList = implode($additionalFunctionNames, ', ');
        }
        return $additionalFunctionsList;
    }

}

?>
