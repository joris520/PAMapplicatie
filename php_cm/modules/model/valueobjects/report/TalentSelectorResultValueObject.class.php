<?php

/**
 * Description of TalentSelectorResultValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

require_once('modules/model/valueobjects/report/TalentSelectorRequestedValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorValueObject.class.php');

class TalentSelectorResultValueObject extends BaseReportValueObject
{
    private $valueObject;
    private $scoreObjects;

    static function createWithValueObject(  $competenceId,
                                            TalentSelectorRequestedValueObject $valueObject)
    {
        return new TalentSelectorResultValueObject( $competenceId,
                                                    $valueObject);
    }

    protected function __construct( $competenceId,
                                    TalentSelectorRequestedValueObject $valueObject)
    {
        parent::__construct($competenceId);
        $this->valueObject  = $valueObject;
        $this->scoreObjects = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getValueObject()
    {
        return $this->valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function addScoreObject(TalentSelectorValueObject $scoreObject)
    {
        $this->scoreObjects[] = $scoreObject;
    }

    function getScoreObjects()
    {
        return $this->scoreObjects;
    }

    function hasScoreObjects()
    {
        return count($this->scoreObjects) > 0;
    }


}

?>
