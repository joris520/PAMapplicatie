<?php


/**
 * Description of QuestionView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class QuestionView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/questionView.tpl';

    private $editLink;
    private $removeLink;

    static function createWithValueObject(  QuestionValueObject $valueObject,
                                            $displayWidth)
    {
        return new QuestionView($valueObject,
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

}

?>
