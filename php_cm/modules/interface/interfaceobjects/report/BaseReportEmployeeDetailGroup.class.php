<?php

/**
 * Description of BaseReportEmployeeDetailGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/BaseReportEmployeeDetailView.class.php');

class BaseReportEmployeeDetailGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/baseReportEmployeeDetailGroup.tpl';

    private $bossName;
    private $countTitle;

    static function create( $displayWidth,
                            $countTitle,
                            $bossName)
    {
        return new BaseReportEmployeeDetailGroup(   $displayWidth,
                                                    $countTitle,
                                                    $bossName);
    }

    protected function __construct( $displayWidth,
                                    $countTitle,
                                    $bossName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->countTitle   = $countTitle;
        $this->bossName     = $bossName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(BaseReportEmployeeDetailView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showCount()
    {
        return $this->countTitle != NULL;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCountTitle()
    {
        return $this->countTitle;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossName()
    {
        return $this->bossName;
    }

}

?>
