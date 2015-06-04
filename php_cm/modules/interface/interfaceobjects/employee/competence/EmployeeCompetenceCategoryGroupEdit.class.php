<?php

/**
 * Description of EmployeeCompetenceCategoryGroupEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeCompetenceCategoryGroupEdit extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceCategoryGroupEdit.tpl';

    // display data
    private $categoryName;
    private $showCategoryName;

    static function create( $displayWidth,
                            $categoryName)
    {
        return new EmployeeCompetenceCategoryGroupEdit( $displayWidth,
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
    function getCategoryName()
    {
        return $this->categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeCompetenceClusterGroupEdit $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCategoryName($showCategoryName)
    {
        $this->showCategoryName = $showCategoryName;
    }

    function showCategoryName()
    {
        return $this->showCategoryName;
    }



}

?>
