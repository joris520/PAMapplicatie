<?php
/**
 * Description of EmployeeJobProfileEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeJobProfileEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeJobProfileEdit.tpl';

    private $unusedFunctionIdValues;

    private $mainFunctionIdValue;
    private $additionalFunctionIdValues;
    private $allFunctionIds;

    static function createWithValueObject(  EmployeeJobProfileValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeJobProfileEdit(  $valueObject,
                                            $displayWidth);
    }

    function __construct(   EmployeeJobProfileValueObject $valueObject,
                            $displayWidth)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        // afgeleide waarden
        $this->mainFunctionIdValue          = NULL;
        $this->additionalFunctionIdValues   = array();
        $this->allFunctionIds               = array();
        $this->unusedFunctionIdValues       = array();

        $this->init();
    }

    function init()
    {
        // hoofdfunctie
        $mainFunction               = $this->valueObject->getMainFunction();
        $additionalFunctions        = $this->valueObject->getAdditionalFunctions();

        $this->mainFunctionIdValue  = IdValue::create(  $mainFunction->getFunctionId(),
                                                        $mainFunction->getFunctionName());
        $this->allFunctionIds[]     = $mainFunction->getFunctionId();

        // nevenfuncties
        foreach ($additionalFunctions as $additionalFunction) {
            $this->additionalFunctionIdValues[] = IdValue::create(  $additionalFunction->getFunctionId(),
                                                                    $additionalFunction->getFunctionName());
            $this->allFunctionIds[]             = $additionalFunction->getFunctionId();
        }
    }

    function setAllFunctionIdValues($allFunctionIdValues)
    {
        // we hebben alleen de niet gebruikte nodig, dus hier overzetten...
        foreach ($allFunctionIdValues as $functionIdValue) {
            $found = array_search($functionIdValue->getDatabaseId(), $this->allFunctionIds);
            if ($found === false) {
                $this->unusedFunctionIdValues[] = $functionIdValue;
            }
        }
    }

    function getUnusedFunctionIdValues()
    {
        return $this->unusedFunctionIdValues;
    }

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

    function getFunctionIdValues()
    {
        return array_merge(array($this->mainFunctionIdValue), $this->additionalFunctionIdValues);
    }

    // afgeleide waarden
    function getFunctionIds()
    {
        return $this->allFunctionIds;
    }

    function getAdditionalFunctionIds()
    {
        return $this->additionalFunctionIds;
    }

    function getAdditionalFunctionNames()
    {
        return $this->additionalFunctionNames;
    }

}

?>
