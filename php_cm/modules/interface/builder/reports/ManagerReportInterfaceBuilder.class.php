<?php

/**
 * Description of ManagerOverviewInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/report/ManagerReportService.class.php');

require_once('modules/model/valueobjects/organisation/DepartmentCollection.class.php');
require_once('modules/model/valueobjects/report/ManagerReportCollection.class.php');

require_once('modules/interface/builder/reports/ManagerReportInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/report/ManagerReportGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ManagerReportView.class.php');
require_once('modules/interface/interfaceobjects/report/ManagerReportDepartmentDetailGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ManagerReportDepartmentDetailView.class.php');


class ManagerReportInterfaceBuilder
{

    static function getViewHtml($displayWidth,
                                ManagerReportCollection $collection)
    {
        $groupInterfaceObject = ManagerReportGroup::create($displayWidth);

        // omzetten naar template data
        foreach($collection->getValueObjects() as $valueObject) {
            $managerReportId = $valueObject->getId();
            $interfaceObject = ManagerReportView::createWithValueObject($valueObject,
                                                                        $displayWidth);

            $interfaceObject->setEmployeeDetailLink(    ManagerReportInterfaceBuilderComponents::getEmployeeInfoLink(   $managerReportId,
                                                                                                                        $valueObject->getSubordinatesCount()));
            $managerUserValueObject = $valueObject->getManagerUserValueObject();
            if (!$managerUserValueObject->hasAllDepartmentsAccess()) {
                $interfaceObject->setDepartmentDetailLink(  ManagerReportInterfaceBuilderComponents::getDepartmentInfoLink( $managerUserValueObject->getId(),
                                                                                                                            $managerUserValueObject->getDepartmentCount()));
            }
            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('REPORT_MANAGERS'),
                                                                    $displayWidth);

        return $blockInterfaceObject->fetchHtml();

    }

    static function getDepartmentsHtml( $displayWidth,
                                        DepartmentCollection $collection)
    {
        $groupInterfaceObject = ManagerReportDepartmentDetailGroup::create($displayWidth);

        // omzetten naar template data
        foreach($collection->getValueObjects() as $valueObject) {
            $interfaceObject = ManagerReportDepartmentDetailView::createWithValueObject($valueObject,
                                                                                        $displayWidth);
            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        return $groupInterfaceObject->fetchHtml();
    }

}

?>
