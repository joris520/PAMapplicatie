<?php

/**
 * Description of PdpActionDashboardValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/PdpActionDashboardCountValueObject.class.php');

class PdpActionDashboardValueObject extends PdpActionDashboardCountValueObject
{
    private $bossName;

    static function create($bossId, $bossName)
    {
        return new PdpActionDashboardValueObject($bossId, $bossName);
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
