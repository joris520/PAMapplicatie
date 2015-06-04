<?php

/**
 * Description of EmployeeInfoHeaderView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeInfoHeaderView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/employeeInfoHeaderView.tpl';

    // de foto
    private $displayablePhoto;
    private $photoWidth;
    private $photoHeight;

    private $isAllowedAddPhoto;
    private $addPhotoLink;

    static function createWithValueObject(  EmployeeInfoValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeInfoHeaderView(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAddPhotoLink($addPhotoLink)
    {
        $this->addPhotoLink = $addPhotoLink;
    }

    function getAddPhotoLink()
    {
        return $this->addPhotoLink;
    }

    function setIsAllowedAddPhoto($isAllowedAddPhoto = true)
    {
        $this->isAllowedAddPhoto = $isAllowedAddPhoto;
    }

    function showAddPhotoLink()
    {
        return $this->isAllowedAddPhoto && !empty($this->addPhotoLink);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // de foto
    function setPhotoInfo($displayablePhoto, $photoWidth, $photoHeight)
    {
        $this->displayablePhoto = $displayablePhoto;
        $this->photoWidth       = $photoWidth;
        $this->photoHeight      = $photoHeight;
    }

    function getDisplayablePhoto()
    {
        return $this->displayablePhoto;
    }

    function getPhotoWidth()
    {
        return $this->photoWidth;
    }

    function getPhotoHeight()
    {
        return $this->photoHeight;
    }



}

?>