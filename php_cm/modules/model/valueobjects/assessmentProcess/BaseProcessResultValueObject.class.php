<?php

/**
 * Description of BaseProcessResultValueObject
 *
 * @author ben.dokter
 */

class BaseProcessResultValueObject
{
    private $bossId;

    protected function __construct($bossId)
    {
        $this->bossId = $bossId;
    }

    function getBossId()
    {
        return $this->bossId;
    }
}

?>
