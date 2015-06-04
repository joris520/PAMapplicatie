<?php

/**
 * Description of TalentSelectorCompetenceGroup
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');

class TalentSelectorResultCompetenceGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorResultCompetenceGroup.tpl';

    private $valueObject;
    private $score;

    static function createWithValueObject(  TalentSelectorRequestedValueObject $valueObject,
                                            $displayWidth)
    {
        return new TalentSelectorResultCompetenceGroup( $valueObject,
                                                        $displayWidth);
    }

    protected function __construct( TalentSelectorRequestedValueObject $valueObject,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->valueObject = $valueObject;
        $this->score       = 0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(TalentSelectorResultView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getValueobject()
    {
        return $this->valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setScore ($score)
    {
        if (!empty($score)) {
            $this->score = ScoreConverter::numeric($score);
        }
    }

    function getScore ()
    {
        return ScoreConverter::scoreInScale($this->score, $this->valueObject->competenceScaleType);
    }
}

?>
