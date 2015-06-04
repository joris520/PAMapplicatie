<?php

/**
 * Description of BaseEmployeeInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/EmployeeInfoValueObject.class.php');

require_once('modules/interface/interfaceobjects/employee/EmployeeInfoHeaderGroup.class.php');
//require_once('modules/interface/interfaceobjects/employee/EmployeeInfoHeaderView.class.php');


abstract class AbstractEmployeeInterfaceBuilder
{
    const PHOTO_SCALE_FACTOR = 3;

    static function getEmployeeInfoHeaderHtml(  $displayWidth,
                                                $employeeId,
                                                EmployeeInfoValueObject $infoValueObject,
                                                EmployeeJobProfileValueObject $jobProfileValueObject = NULL)
    {
        $groupInterfaceObject = self::getGroupInterfaceObject(  $displayWidth,
                                                                $employeeId,
                                                                $infoValueObject,
                                                                $jobProfileValueObject);
        return $groupInterfaceObject->fetchHtml();
    }

    static function getGroupInterfaceObject($displayWidth,
                                            $employeeId,
                                            EmployeeInfoValueObject $infoValueObject,
                                            EmployeeJobProfileValueObject $jobProfileValueObject = NULL)
    {
        $infoInterfaceObject = EmployeeInfoHeaderView::createWithValueObject(   $infoValueObject,
                                                                                $displayWidth);

        $infoInterfaceObject->addActionLink(    EmployeePrintInterfaceBuilderComponents::getPrintLink($employeeId));

        $photoFile = $infoValueObject->getPhotoFile();

        if (!empty($photoFile)) {
            $employeePhoto = new PhotoContent();
            list($displayablePhoto, $photoWidth, $photoHeight) = $employeePhoto->getEmployeeDisplayablePhoto($photoFile);

            $photoWidthScaled = $photoWidth/self::PHOTO_SCALE_FACTOR;
            $photoHeightScaled = $photoHeight/self::PHOTO_SCALE_FACTOR;
            $infoInterfaceObject->setPhotoInfo( $displayablePhoto,
                                                $photoWidthScaled,
                                                $photoHeightScaled);
        } else {
            if (CUSTOMER_OPTION_SHOW_DUMMY_THUMBNAIL) {
                $employeeValueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
                $gender = $employeeValueObject->getGender();
                switch ($gender) {
                    case  EmployeeGenderValue::FEMALE:
                        $dummyThumb = EMPLOYEE_GENERIC_FEMALE_THUMB;
                        break;
                    case  EmployeeGenderValue::MALE:
                        $dummyThumb = EMPLOYEE_GENERIC_MALE_THUMB;
                        break;
                    default:
                        $dummyThumb = EMPLOYEE_GENERIC_UNKNOWN_THUMB;
                        break;
                }
                if (!empty($dummyThumb)) {
                    $infoInterfaceObject->setPhotoInfo( $dummyThumb,
                                                        DEFAULT_GENERIC_FEMALE_THUMB_WIDTH,
                                                        DEFAULT_GENERIC_FEMALE_THUMB_HEIGHT);
                    $infoInterfaceObject->setAddPhotoLink( EmployeeProfilePersonalInterfaceBuilderComponents::getAddPhotoUrl($employeeId));
                }
            }
        }
//    isMale($value)
//    isFemale($value)
        if (!is_null($jobProfileValueObject)) {
            $jobProfileInterfaceObject  = EmployeeJobProfileInterfaceBuilder::getHeaderViewInterfaceObject( $displayWidth,
                                                                                                            $employeeId,
                                                                                                            $jobProfileValueObject);
        }

        // de losse views verzamelen in een group
        $groupInterfaceObject = EmployeeInfoHeaderGroup::create($infoInterfaceObject,
                                                                $jobProfileInterfaceObject,
                                                                $displayWidth);


        return $groupInterfaceObject;
    }

}

?>
