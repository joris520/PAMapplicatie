<?php

/**
 * Description of EmployeeCompetencePrintOptionDetail
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BasePrintOptionDetailInterfaceObject.class.php');

class EmployeeCompetencePrintOptionDetail extends BasePrintOptionDetailInterfaceObject
{
    const TEMPLATE_FILE = 'employee/print/employeeCompetencePrintOptionDetail.tpl';

    const ALL_CHECKED   = TRUE;
    const NONE_CHECKED  = FALSE;

    private $isAllowedShowRemarks;
    private $isAllowedShow360;
    private $isAllowedShowPdpAction;

    private $isChecked;

    static function create( $displayWidth,
                            $printOption,
                            $detailIndentation,
                            $isInitialVisible,
                            $isChecked = self::ALL_CHECKED)
    {
        return new EmployeeCompetencePrintOptionDetail( $displayWidth,
                                                        $printOption,
                                                        $detailIndentation,
                                                        $isInitialVisible,
                                                        $isChecked);
    }

    protected function __construct( $displayWidth,
                                    $printOption,
                                    $detailIndentation,
                                    $isInitialVisible,
                                    $isChecked = self::ALL_CHECKED)
    {
        parent::__construct($displayWidth,
                            $printOption,
                            $detailIndentation,
                            $isInitialVisible,
                            self::TEMPLATE_FILE);

        $this->setIsChecked($isChecked == $isChecked = self::ALL_CHECKED);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsChecked($isChecked)
    {
        $this->isChecked = $isChecked;
    }

    function isChecked()
    {
        return $this->isChecked;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsAllowedShowRemarks($isAllowedShowRemarks)
    {
        $this->isAllowedShowRemarks = $isAllowedShowRemarks;
    }

    function isAllowedShowRemarks()
    {
        return $this->isAllowedShowRemarks;
    }

    function setIsAllowedShow360($isAllowedShow360)
    {
        $this->isAllowedShow360 = $isAllowedShow360;
    }

    function isAllowedShow360()
    {
        return $this->isAllowedShow360;
    }

    function setIsAllowedShowPdpAction($isAllowedShowPdpAction)
    {
        $this->isAllowedShowPdpAction = $isAllowedShowPdpAction;
    }

    function isAllowedShowPdpAction()
    {
        return $this->isAllowedShowPdpAction;
    }
}

?>
