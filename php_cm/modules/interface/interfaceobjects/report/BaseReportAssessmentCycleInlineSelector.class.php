<?php

/**
 * Description of BaseReportAssessmentCycleInlineSelector
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseReportAssessmentCycleInlineSelector extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'report/baseReportAssessmentCycleInlineSelector.tpl';

    private $safeFormIdentifier;
    private $formId;

    private $cancelLink;

    private $idValues;
    private $currentId;

    static function create( $inlineSafeFormIdentifier,
                            $inlineFormId,
                            $displayWidth)
    {
        return new BaseReportAssessmentCycleInlineSelector( $inlineSafeFormIdentifier,
                                                            $inlineFormId,
                                                            $displayWidth);
    }

    protected function __construct( $inlineSafeFormIdentifier,
                                    $inlineFormId,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->safeFormIdentifier   = $inlineSafeFormIdentifier;
        $this->formId               = $inlineFormId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getSafeFormIdentifier()
    {
        return $this->safeFormIdentifier;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getFormId()
    {
        return $this->formId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCancelLink($cancelLink)
    {
        $this->cancelLink = $cancelLink;
    }

    function getCancelLink()
    {
        return $this->cancelLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIdValues(Array /* IdValue */ $idValues)
    {
        $this->idValues = $idValues;
    }

    function getIdValues()
    {
        return $this->idValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCurrentId($currentId)
    {
        $this->currentId = $currentId;
    }

    function getCurrentId()
    {
        return $this->currentId;
    }



}

?>
