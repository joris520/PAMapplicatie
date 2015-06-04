<?php

/**
 * Description of EmployeePdpActionCompetenceSelectCategoryGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeePdpActionCompetenceSelectCategoryGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionCompetenceSelectCategoryGroup.tpl';

    private $categoryName;
    private $showCategory;

    static function create( $displayWidth,
                            $categoryName)
    {
        return new EmployeePdpActionCompetenceSelectCategoryGroup(  $displayWidth,
                                                                    $categoryName);
    }

    protected function __construct( $displayWidth,
                                    $categoryName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->categoryName = $categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeePdpActionCompetenceSelectClusterGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCategoryName()
    {
        return $this->categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCategory($showCategory)
    {
        $this->showCategory = $showCategory;
    }

    function showCategory()
    {
        return $this->showCategory;
    }
}

?>
