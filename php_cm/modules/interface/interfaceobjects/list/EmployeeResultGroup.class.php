<?php

/**
 * Description of EmployeeResultList
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeResultGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeResultGroup.tpl';

    private $useLimit;
    private $limit;

    private $showLimitText;

    static function create( $displayWidth,
                            $showLimitText,
                            $useLimit,
                            $limit)
    {
        return new EmployeeResultGroup( $displayWidth,
                                        $showLimitText,
                                        $useLimit,
                                        $limit);
    }

    function __construct(   $displayWidth,
                            $showLimitText,
                            $useLimit,
                            $limit)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->showLimitText    = $showLimitText;
        $this->useLimit         = $useLimit;
        $this->limit            = $limit;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeResultListView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showLimitText()
    {
        return $this->showLimitText;
    }

    function hasHitLimit()
    {
        return $this->useLimit && count($this->interfaceObjects) >= $this->limit;
    }

}

?>
