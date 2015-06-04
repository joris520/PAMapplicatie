<?php

/**
 * Description of EmployeePdpActionCompetenceSelectClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeePdpActionCompetenceSelectClusterGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionCompetenceSelectClusterGroup.tpl';

    private $clusterName;

    static function create( $displayWidth,
                            $clusterName)
    {
        return new EmployeePdpActionCompetenceSelectClusterGroup(   $displayWidth,
                                                                    $clusterName);
    }

    protected function __construct( $displayWidth,
                                    $clusterName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->clusterName = $clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeePdpActionCompetenceSelectView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterName()
    {
        return $this->clusterName;
    }}

?>
