<?php

/**
 * Description of TargetDashboardValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/report/TargetDashboardCountValueObject.class.php');

class TargetDashboardValueObject extends TargetDashboardCountValueObject
{
    private $bossName;

    static function create($bossId, $bossName)
    {
        return new TargetDashboardValueObject($bossId, $bossName);
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
