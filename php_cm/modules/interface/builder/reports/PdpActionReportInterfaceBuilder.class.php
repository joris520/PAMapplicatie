<?php

/**
 * Description of PdpActionReportInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilder.class.php');

require_once('modules/interface/builder/reports/PdpActionReportInterfaceBuilderComponents.class.php');

require_once('modules/interface/interfaceobjects/report/PdpActionDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/PdpActionDashboardView.class.php');

require_once('modules/model/service/report/PdpActionReportService.class.php');
require_once('modules/model/valueobjects/report/PdpActionDashboardCollection.class.php');

class PdpActionReportInterfaceBuilder extends BaseReportEmployeeInterfaceBuilder
{
    const SHOW_TOTALS = true;
    const HIDE_TOTALS = false;

    static function getDashboardViewHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            $showTotals,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            PdpActionDashboardCollection $dashboardCollection)
    {

        $totalCountValueObject = $dashboardCollection->getTotalCountValueObject();
        $keyIdValues = $dashboardCollection->getKeyIdValues();

        $groupInterfaceObject = PdpActionDashboardGroup::create($totalCountValueObject,
                                                                $showTotals == self::SHOW_TOTALS,
                                                                $displayWidth);

        $groupInterfaceObject->setKeyIdValues($keyIdValues);
        // per leidinggevenden de medewerkers ophalen
        // allen, inclusief zonder leidinggevende
        $valueObjects = $dashboardCollection->getValueObjects();
        foreach($valueObjects as $valueObject) {
            $interfaceObject = self::getDashboardViewForBoss( $displayWidth,
                                                              $keyIdValues,
                                                              $valueObject);
            $interfaceObject->setKeyIdValues($keyIdValues);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        if ($showTotals) {
            // de total links toevoegen
            $employeesTotalDetailLink =
                PdpActionReportInterfaceBuilderComponents::getEmployeesTotalDetailLink( BossFilterValue::ALL,
                                                                                        $totalCountValueObject->getEmployeesTotal());
            $groupInterfaceObject->setTotalDetailLink($employeesTotalDetailLink);

            $withoutDetailLink =
                PdpActionReportInterfaceBuilderComponents::getCompletedStatusDetailLink(BossFilterValue::ALL,
                                                                                        PdpActionCompletedStatusValue::NO_PDP_ACTION,
                                                                                        $valueObject->getEmployeesWithout());
            $groupInterfaceObject->setWithoutDetailLink($withoutDetailLink);


            foreach($keyIdValues as $keyIdValue) {
                $key = $keyIdValue->getDatabaseId();
                $keyDetailLink =
                    PdpActionReportInterfaceBuilderComponents::getCompletedStatusDetailLink(BossFilterValue::ALL,
                                                                                            $key,
                                                                                            $totalCountValueObject->getEmployeeCountForKey($key));

                $groupInterfaceObject->setKeyDetailLink($key,
                                                        $keyDetailLink);
            }
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('DASHBOARD_PDP_ACTIONS'),
                                                                    $displayWidth);
        //$blockInterfaceObject->setActionsWidth($selectorWidth);

        // een extra regel voor de assessment cycle
        $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getReportInfo(  $displayWidth,
                                                                                $assessmentCycle,
                                                                                MESSAGE_WARNING);
        $additionalRow = BaseBlockHeaderRowInterfaceObject::create( $assessmentCycleInfo,
                                                                    $displayWidth);
        $additionalRow->setHiliteRow($doHilite);//!$assessmentCycleInfo->isCurrentAssessmentCycle());

        $additionalRow->setActionId(    self::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE);
        $additionalRow->setActionsWidth($selectorWidth);
        $additionalRow->addActionLink(   PdpActionReportInterfaceBuilderComponents::getEditAssessmentCycleLink());
        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        return $blockInterfaceObject->fetchHtml();

    }

    private static function getDashboardViewForBoss(  $displayWidth,
                                                      Array /* IdValue */ $keyIdValues,
                                                      PdpActionDashboardValueObject $valueObject)
    {
        $bossId = $valueObject->getBossId();

        $interfaceObject = PdpActionDashboardView::create(  $valueObject,
                                                            $displayWidth);

        $totalDetailLink =
            PdpActionReportInterfaceBuilderComponents::getEmployeesTotalDetailLink( $bossId,
                                                                                    $valueObject->getEmployeesTotal());
        $interfaceObject->setTotalDetailLink($totalDetailLink);

        $withoutDetailLink =
            PdpActionReportInterfaceBuilderComponents::getCompletedStatusDetailLink($bossId,
                                                                                    PdpActionCompletedStatusValue::NO_PDP_ACTION,
                                                                                    $valueObject->getEmployeesWithout());
        $interfaceObject->setWithoutDetailLink($withoutDetailLink);


        foreach($keyIdValues as $keyIdValue) {
            $key = $keyIdValue->getDatabaseId();
            $keyDetailLink =
                PdpActionReportInterfaceBuilderComponents::getCompletedStatusDetailLink($bossId,
                                                                                        $key,
                                                                                        $valueObject->getEmployeeCountForKey($key));

            $interfaceObject->setKeyDetailLink($key, $keyDetailLink);
        }

        return $interfaceObject;
    }

}

?>
