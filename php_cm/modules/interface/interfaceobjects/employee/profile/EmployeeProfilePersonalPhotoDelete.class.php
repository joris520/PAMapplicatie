<?php

/**
 * Description of EmployeeProfilePersonalPhotoDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfilePersonalPhotoDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfilePersonalPhotoDelete.tpl';

    private $displayablePhoto;
    private $photoWidth;
    private $photoHeight;

    private $confirmQuestion;

    static function createWithValueObject(  EmployeeProfilePersonalValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfilePersonalPhotoDelete(  $valueObject,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setConfirmQuestion($confirmQuestion)
    {
        $this->confirmQuestion = $confirmQuestion;
    }

    function getConfirmQuestion()
    {
        return $this->confirmQuestion;
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
