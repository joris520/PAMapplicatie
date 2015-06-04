<?php

/**
 * Description of EmployeePdpActionCompetenceSelector
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeePdpActionCompetenceSelector extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionCompetenceSelector.tpl';

    private $interfaceObject;
    private $toggleHtmlId;
    private $contentHtmlId;

    private $relatedCompetenceLabel;


    static function create( $displayWidth,
                            $toggleHtmlId,
                            $contentHtmlId)
    {
        return new EmployeePdpActionCompetenceSelector( $displayWidth,
                                                        $toggleHtmlId,
                                                        $contentHtmlId);
    }

    protected function __construct( $displayWidth,
                                    $toggleHtmlId,
                                    $contentHtmlId)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->toggleHtmlId   = $toggleHtmlId;
        $this->contentHtmlId  = $contentHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getToggleHtmlId()
    {
        return $this->toggleHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentHtmlId()
    {
        return $this->contentHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInterfaceObject(EmployeePdpActionCompetenceSelectGroup $interfaceObject)
    {
        $this->interfaceObject = $interfaceObject;
    }

    function getInterfaceObject()
    {
        return $this->interfaceObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRelatedCompetenceLabel($relatedCompetenceLabel)
    {
        $this->relatedCompetenceLabel = $relatedCompetenceLabel;
    }

    function getRelatedCompetenceLabel()
    {
        return $this->relatedCompetenceLabel;
    }

}

?>
