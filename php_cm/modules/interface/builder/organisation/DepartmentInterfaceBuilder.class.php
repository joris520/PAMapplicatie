<?php

/**
 * Description of DepartmentInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/organisation/DepartmentInterfaceBuilderComponents.class.php');

require_once('modules/model/service/organisation/DepartmentService.class.php');

require_once('modules/interface/interfaceobjects/organisation/DepartmentDelete.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentEdit.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentGroup.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentView.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentDetailEmployeeGroup.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentDetailEmployeeView.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentDetailUserGroup.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentDetailUserView.class.php');

require_once('application/interface/converter/NumberConverter.class.php');

class DepartmentInterfaceBuilder
{

    static function getViewHtml($displayWidth,
                                $permission,
                                $hiliteId = NULL)
    {
        $valueObjects = DepartmentService::getValueObjects(DepartmentService::INCLUDE_USAGE_INFORMATION);

        // groep
        $groupInterfaceObject = DepartmentGroup::create($displayWidth);

        // omzetten naar template data
        foreach($valueObjects as $valueObject) {
            $departmentId = $valueObject->getId();
            $interfaceObject = DepartmentView::createWithValueObject(   $valueObject,
                                                                        $displayWidth);

            $interfaceObject->setHiliteRow( $departmentId == $hiliteId);
            $interfaceObject->setEditLink(  DepartmentInterfaceBuilderComponents::getEditLink($departmentId, $permission));
            $interfaceObject->setRemoveLink(DepartmentInterfaceBuilderComponents::getRemoveLink($departmentId, $permission));
            $interfaceObject->setEmployeeDetailLink(DepartmentInterfaceBuilderComponents::getEmployeeInfoLink($departmentId, $valueObject->getTotalCountedEmployees()));
            $interfaceObject->setUserDetailLink(    DepartmentInterfaceBuilderComponents::getDepartmentInfoLink($departmentId, $valueObject->getTotalCountedUsers()));

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCF('MANAGE_DEPARTMENTS'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   DepartmentInterfaceBuilderComponents::getAddLink($permission));

        return $blockInterfaceObject->fetchHtml();

    }


    static function getAddHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__ADD_DEPARTMENT);

        $safeFormHandler->addStringInputFormatType('department_name');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = DepartmentValueObject::createWithData(NULL, NULL, NULL);
        $interfaceObject = DepartmentEdit::createWithValueObject(   $valueObject,
                                                                    $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    static function getEditHtml($displayWidth, $departmentId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__EDIT_DEPARTMENT);

        $safeFormHandler->storeSafeValue('departmentId', $departmentId);
        $safeFormHandler->addStringInputFormatType('department_name');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = DepartmentService::getValueObjectById($departmentId);
        $interfaceObject = DepartmentEdit::createWithValueObject(   $valueObject,
                                                                    $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml($displayWidth, $departmentId)
    {
        // ophalen ValueObject
        $valueObject = DepartmentService::getValueObjectById($departmentId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__DELETE_DEPARTMENT);

        $safeFormHandler->storeSafeValue('departmentId', $departmentId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = DepartmentDelete::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_DEPARTMENT'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

//    static function getEmployeesHtml(   $displayWidth
//                                        $contentHeight,
//                                        $departmentId)
//    {
//        // TODO: functie naar EmployeeService
//        $employeeIds    = DepartmentService::getEmployeeIdsForDepartment($departmentId);
//        $collection     = BaseReportEmployeeService::getCollectionForDepartment($departmentId,
//                                                                                $employeeIds);
//
//        $groupCollection = BaseReportEmployeeGroupCollection::create();
//        $groupCollection->setCollection($departmentId,
//                                        $collection);
//
//        $popupHtml  = BaseReportEmployeePageBuilder::getEmployeesPopupHtml( self::INFO_DIALOG_WIDTH,
//                                                                            self::INFO_CONTENT_HEIGHT,
//                                                                            $groupCollection);
//
//        return $popupHtml;
//        // groep
//        $groupInterfaceObject = DepartmentDetailEmployeeGroup::create($displayWidth);
//
//        // omzetten naar template data
//        foreach($valueObjects as $valueObject) {
//            $interfaceObject = DepartmentDetailEmployeeView::createWithValueObject( $valueObject,
//                                                                                    $displayWidth);
//            $groupInterfaceObject->addInterfaceObject($interfaceObject);
//        }
//
//        return $groupInterfaceObject->fetchHtml();
//    }

    static function getUsersHtml($displayWidth, $departmentId)
    {
        // TODO: functie naar UserService
        $valueObjects = DepartmentService::getUserValueObjectsForDepartment($departmentId);
        // groep
        $groupInterfaceObject = DepartmentDetailUserGroup::create($displayWidth);

        // omzetten naar template data
        foreach($valueObjects as $valueObject) {
            $interfaceObject = DepartmentDetailUserView::createWithValueObject( $valueObject,
                                                                                $displayWidth);
            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        return $groupInterfaceObject->fetchHtml();
    }

}

?>
