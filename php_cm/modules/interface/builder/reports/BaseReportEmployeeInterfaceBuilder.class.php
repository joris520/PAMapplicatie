<?php

/**
 * Description of BaseReportEmployeeInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilder.class.php');
require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilderComponents.class.php');

require_once('modules/interface/interfaceobjects/report/BaseReportEmployeeDetailGroup.class.php');
require_once('modules/interface/interfaceobjects/report/BaseReportEmployeeDetailView.class.php');
require_once('modules/interface/interfaceobjects/report/BaseReportAssessmentCycleInlineSelector.class.php');

require_once('modules/model/valueobjects/report/BaseReportEmployeeCollection.class.php');

class BaseReportEmployeeInterfaceBuilder extends BaseReportInterfaceBuilder
{

    const HIDE_COUNT = FALSE;
    const SHOW_COUNT = TRUE;

    static function getEmployeesHtml(   $displayWidth,
                                        BaseReportEmployeeCollection $collection,
                                        $countColumnTitle = NULL)
    {
        // groep
        $groupInterfaceObject = BaseReportEmployeeDetailGroup::create(  $displayWidth,
                                                                        $countColumnTitle,
                                                                        $collection->getBossName());

        // omzetten naar template data
        foreach($collection->getValueObjects() as $valueObject) {
            $interfaceObject = BaseReportEmployeeDetailView::createWithValueObject( $valueObject,
                                                                                    $countColumnTitle != NULL,
                                                                                    $displayWidth);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);

            // todo: doorlinken naar dossier...
        }

        return $groupInterfaceObject->fetchHtml();
    }


}

?>
