<?php

/**
 * Description of FinalResultDashboardValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/FinalResultDashboardCountValueObject.class.php');

class FinalResultDashboardValueObject extends FinalResultDashboardCountValueObject
{
    private $bossName;

    static function create($bossId, $bossName)
    {
        return new FinalResultDashboardValueObject($bossId, $bossName);
    }

    protected function __construct($bossId, $bossName)
    {
        parent::__construct($bossId);
        $this->bossName = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossId()
    {
        return $this->getId();
    }

    function getBossName()
    {
        return $this->bossName;
    }

}

?>
