<?php

/**
 * Description of AssessmentProcessActionView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionView.tpl';

    private $replaceHtmlId;
    private $actionHtml;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionView( $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setReplaceHtmlId($replaceHtmlId)
    {
        $this->replaceHtmlId = $replaceHtmlId;
    }

    function getReplaceHtmlId()
    {
        return $this->replaceHtmlId;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setActionHtml($actionHtml)
    {
        $this->actionHtml = $actionHtml;
    }

    function getActionHtml()
    {
        return $this->actionHtml;
    }

}


?>
