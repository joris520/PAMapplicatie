<?php


/**
 * Description of AssessmentCycleView
 *
 * @author hans.prins
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class AssessmentCycleView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleView.tpl';

    private $editLink;
    private $removeLink;
    private $isCurrentCycle;

    static function createWithValueObject(  AssessmentCycleValueObject $valueObject,
                                            $displayWidth)
    {
        return new AssessmentCycleView( $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
    }

    function getEditLink()
    {
        return $this->editLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRemoveLink($removeLink)
    {
        $this->removeLink = $removeLink;
    }

    function getRemoveLink()
    {
        return $this->removeLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsCurrentCycle($isCurrentCycle)
    {
        $this->isCurrentCycle = $isCurrentCycle;
    }

    function isCurrentCycle()
    {
        return $this->isCurrentCycle;
    }

}

?>
