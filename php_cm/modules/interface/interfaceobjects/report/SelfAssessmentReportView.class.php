<?php

/**
 * Description of SelfAssessmentReportView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class SelfAssessmentReportView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/selfAssessmentReportView.tpl';

    const SHOW_DETAIL_LINK = TRUE;
    const HIDE_DETAIL_LINK = FALSE;

    private $assessmentCycleValueObject;

    private $detailLink;
    private $showLink;


    static function createWithValueObject(  SelfAssessmentReportInvitationValueObject $valueObject,
                                            AssessmentCycleValueObject $assessmentCycleValueObject,
                                            $displayWidth)
    {
        return new SelfAssessmentReportView($valueObject,
                                            $assessmentCycleValueObject,
                                            $displayWidth);
    }

    protected function __construct( SelfAssessmentReportInvitationValueObject $valueObject,
                                    AssessmentCycleValueObject $assessmentCycleValueObject,
                                    $displayWidth)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            self::TEMPLATE_FILE);

        $this->assessmentCycleValueObject = $assessmentCycleValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentCycleValueObject()
    {
        return $this->assessmentCycleValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDetailLink($detailLink)
    {
        $this->detailLink = $detailLink;
    }

    function getDetailLink()
    {
        return $this->detailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowLink($showLink)
    {
        $this->showLink = $showLink;
    }

    function getShowLink()
    {
        return $this->showLink;
    }

}

?>
