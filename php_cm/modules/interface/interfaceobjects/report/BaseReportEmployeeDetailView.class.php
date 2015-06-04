<?php

/**
 * Description of ManagerReportEmployeeDetailView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');
require_once('modules/model/valueobjects/report/BaseReportEmployeeValueObject.class.php');

class BaseReportEmployeeDetailView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/baseReportEmployeeDetailView.tpl';

    private $showCount;

    static function createWithValueObject(  BaseReportEmployeeValueObject $valueObject,
                                            $showCount,
                                            $displayWidth)
    {
        return new BaseReportEmployeeDetailView($valueObject,
                                                $showCount,
                                                $displayWidth);
    }

    protected function __construct( BaseReportEmployeeValueObject $valueObject,
                                    $showCount,
                                    $displayWidth)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        $this->showCount = $showCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showCount()
    {
        return $this->showCount;
    }


}

?>
