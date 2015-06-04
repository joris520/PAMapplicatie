<?php

/**
 * Description of EmployeePrintOptionsDialog
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectPrintOptionsInterfaceObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');

class EmployeePrintOptionsDialog extends BaseValueObjectPrintOptionsInterfaceObject
{

    const TEMPLATE_FILE = 'employee/print/employeePrintOptionsDialog.tpl';

    private $printOptionDetails;
    private $checkedPrintOptions;

    static function create( EmployeePrintOptionValueObject $valueObject,
                            $displayWidth,
                            $detailIndentation)
    {
        return new EmployeePrintOptionsDialog(  $valueObject,
                                                $displayWidth,
                                                $detailIndentation);
    }

    protected function __construct( EmployeePrintOptionValueObject $valueObject,
                                    $displayWidth,
                                    $detailIndentation)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            $detailIndentation,
                            self::TEMPLATE_FILE);
        $this->employeePrintOptionDetails = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPrintOptionDetail(  $printOption,
                                    BasePrintOptionsInterfaceObject $printOptionDetail)
    {
        $this->printOptionDetails[$printOption] = $printOptionDetail;
    }

    function getPrintOptionDetail($printOption)
    {
        return $this->printOptionDetails[$printOption];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCheckedPrintOptions($checkedPrintOptions)
    {
        $this->checkedPrintOptions = $checkedPrintOptions;
    }

    function getCheckedPrintOptions()
    {
        return $this->checkedPrintOptions;
    }

}

?>
