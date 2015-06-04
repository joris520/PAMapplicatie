<?php

/**
 * Description of BaseReportPeriodDatesEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseReportPeriodDatesEdit extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'report/baseReportPeriodDatesEdit.tpl';

    private $startDatePicker;
    private $endDatePicker;

    static function create( $displayWidth)
    {
        return new BaseReportPeriodDatesEdit(   $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setStartDatePicker($startDatePicker)
    {
        $this->startDatePicker = $startDatePicker;
    }

    function getStartDatePicker()
    {
        return $this->startDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEndDatePicker($endDatePicker)
    {
        $this->endDatePicker = $endDatePicker;
    }

    function getEndDatePicker()
    {
        return $this->endDatePicker;
    }

}

?>
