<?php

/**
 * Description of BaseReportEmployeeCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/report/BaseReportEmployeeValueObject.class.php');

class BaseReportEmployeeCollection extends BaseCollection
{
    private $bossId;
    private $bossName;

    static function create( $bossId,
                            $bossName)
    {
        return new BaseReportEmployeeCollection($bossId,
                                                $bossName);

    }
    protected function __construct( $bossId,
                                    $bossName)
    {
        parent::__construct();
        $this->bossId   = $bossId;
        $this->bossName = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addValueObject(BaseReportEmployeeValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossId()
    {
        return $this->bossId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
    }

}

?>
