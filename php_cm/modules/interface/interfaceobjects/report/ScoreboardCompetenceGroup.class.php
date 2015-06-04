<?php

/**
 * Description of ScoreboardCompetenceGroup
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');

class ScoreboardCompetenceGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = NULL;

    private $valueObject;
    private $score;
    private $scoreCount;


    static function create( $valueObject,
                            $displayWidth)
    {
        return new ScoreboardCompetenceGroup(   $valueObject,
                                                $displayWidth);
    }

    protected function __construct($valueObject,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->valueObject = $valueObject;
        $this->score       = 0;
        $this->scoreCount  = 0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(ScoreboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getValueobject() {
       return $this->valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addScore ($score) {
        if (!empty($score)) {
            $this->score += ScoreConverter::numeric($score);
            $this->scoreCount += 1;
        }
    }

    function setScore ($score) {
        if (!empty($score)) {
            $this->score = ScoreConverter::numeric($score);
            $this->scoreCount = 1;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getScore () {
        return ScoreConverter::scoreInScale($this->score, $this->valueObject->competenceScaleType);
    }

    function getNumericAverage () {
        $numericAverage = 0;
        if ($this->scoreCount > 0) {
            $numericAverage = round($this->score / $this->scoreCount);
        }
        return $numericAverage;
    }

    function getScoreAverage() {
        $score = $this->getNumericAverage();
        return ScoreConverter::scoreInScale($score, $this->valueObject->competenceScaleType);
    }
}

?>
