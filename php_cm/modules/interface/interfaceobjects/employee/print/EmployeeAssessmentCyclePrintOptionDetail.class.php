<?php

/**
 * Description of EmployeeAssessmentCyclePrintOptionDetail
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BasePrintOptionDetailInterfaceObject.class.php');

class EmployeeAssessmentCyclePrintOptionDetail extends BasePrintOptionDetailInterfaceObject
{
    const TEMPLATE_FILE = 'employee/print/employeeAssessmentCycleDetailPrintOptionDetail.tpl';

    private $currentValue;
    private $selectableValues;

    static function create( $displayWidth,
                            $printOption,
                            $detailIndentation,
                            $isInitialVisible,
                            $selectedValue)
    {
        return new EmployeeAssessmentCyclePrintOptionDetail($displayWidth,
                                                            $printOption,
                                                            $detailIndentation,
                                                            $isInitialVisible,
                                                            $selectedValue);
    }

    protected function __construct( $displayWidth,
                                    $printOption,
                                    $detailIndentation,
                                    $isInitialVisible,
                                    $selectedValue)
    {
        parent::__construct($displayWidth,
                            $printOption,
                            $detailIndentation,
                            $isInitialVisible,
                            self::TEMPLATE_FILE);

        $this->setCurrentValue($selectedValue);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;
    }

    function getCurrentValue()
    {
        return $this->currentValue;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelectableValues($selectableValues)
    {
        $this->selectableValues = $selectableValues;
    }

    function getSelectableValues()
    {
        return $this->selectableValues;
    }

}

?>
