<?php

/**
 * Description of BaseApplicationInterfaceObject
 *
 * @author ben.dokter
 */
class BaseApplicationInterfaceObject
{
    var $displayWidth;
    protected $displayWidthNumber;

    protected $templateFile;

    protected $requiredFieldIndicator;

    protected $hiliteRow;

    protected $debug;

    protected function __construct( $displayWidth,
                                    $templateFile)
    {
        $this->displayWidth             = $displayWidth . (is_numeric($displayWidth) ? 'px': '');
        $this->displayWidthNumber       = $displayWidth;

        $this->templateFile             = $templateFile;

        $this->debug                    = APPLICATION_DEBUG_INTERFACE;
        $this->requiredFieldIndicator   = REQUIRED_FIELD_INDICATOR;

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDisplayWidth($correction = NULL)
    {
        $displayWidth = $this->displayWidth;
        if (!is_null($correction) && is_numeric($this->displayWidthNumber)) {
            $displayWidth = ($this->displayWidthNumber + $correction) . 'px';
        }
        return $displayWidth;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // gebruik smarty om met de templateFile de html te genereren
    function fetchHtml()
    {
        $html = '';

        if (!empty($this->templateFile)) {
            // vullen smarty template
            global $smarty;
            $template = $smarty->createTemplate($this->templateFile);
            $template->assign('interfaceObject', $this);

            $html = $smarty->fetch($template);
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDisplayStyle($displayValue)
    {
        $displayStyle = $displayValue;
        if (!is_null($displayValue) && is_numeric($displayValue)) {
            $displayStyle = $displayValue . 'px';
        }
        return $displayStyle;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTemplateFile($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    function getTemplateFile()
    {
        return $this->templateFile;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getRequiredFieldIndicator()
    {
        return $this->requiredFieldIndicator;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDebug()
    {
        return $this->debug;
    }

    function showDebug()
    {
        return $this->debug;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHiliteRow($hiliteRow)
    {
        $this->hiliteRow = $hiliteRow;
    }

    function hiliteRow()
    {
        return $this->hiliteRow;
    }


}

?>
