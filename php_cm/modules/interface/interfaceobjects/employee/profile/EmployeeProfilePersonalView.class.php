<?php

/**
 * Description of EmployeeProfilePersonalView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfilePersonalView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfilePersonalView.tpl';

    private $deletePhotoLink;

    private $displayablePhoto;
    private $photoWidth;
    private $photoHeight;


    static function createWithValueObject(  EmployeeProfilePersonalValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfilePersonalView( $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $deletePhotoLink
    function setDeletePhotoLink($deletePhotoLink)
    {
        $this->deletePhotoLink = $deletePhotoLink;
    }

    function getDeletePhotoLink()
    {
        return $this->deletePhotoLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // de foto
    function setPhoto($displayablePhoto, $photoWidth, $photoHeight)
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
