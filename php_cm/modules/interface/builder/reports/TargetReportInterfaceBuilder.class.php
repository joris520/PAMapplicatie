<?php

/**
 * Description of TargetReportInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilder.class.php');

require_once('modules/interface/builder/reports/TargetReportInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/report/TargetDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/TargetDashboardView.class.php');

require_once('modules/model/service/report/TargetReportService.class.php');
require_once('modules/model/valueobjects/report/TargetDashboardCollection.class.php');

//require_once('modules/interface/interfaceobjects/report/');

class TargetReportInterfaceBuilder  extends BaseReportEmployeeInterfaceBuilder
{
    const SHOW_TOTALS = true;
    const HIDE_TOTALS = false;

    static function getDashboardViewHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            $showTotals,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            TargetDashboardCollection $dashboardCollection)
    {

        $totalCountValueObject = $dashboardCollection->getTotalCountValueObject();
        $keyIdValues = TargetReportService::getStatusIdValues();

        $groupInterfaceObject = TargetDashboardGroup::create(   $totalCountValueObject,
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
            // de BossFilterValue::IS_BOSS waarde "misbruiken"

            $employeesTotalDetailLink =
                TargetReportInterfaceBuilderComponents::getEmployeesTotalDetailLink(BossFilterValue::ALL,
                                                                                    $totalCountValueObject->getEmployeesTotal());
            $groupInterfaceObject->setTotalDetailLink($employeesTotalDetailLink);

            $employeesWithoutDetailLink =
                TargetReportInterfaceBuilderComponents::getStatusDetailLink(BossFilterValue::ALL,
                                                                            EmployeeTargetStatusValue::NO_TARGET,
                                                                            $totalCountValueObject->getEmployeesWithout());
            $groupInterfaceObject->setWithoutDetailLink($employeesWithoutDetailLink);

            foreach($keyIdValues as $keyIdValue) {
                $key = $keyIdValue->getDatabaseId();
                $keyDetailLink =
                    TargetReportInterfaceBuilderComponents::getStatusDetailLink(BossFilterValue::ALL,
                                                                                $key,
                                                                                $totalCountValueObject->getEmployeeCountForKey($key));

                $groupInterfaceObject->setKeyDetailLink($key, $keyDetailLink);
            }
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('MENU_DASHBOARD_PREFIX') . '&nbsp;' . TXT_UCW(CUSTOMER_TARGETS_TAB_LABEL),
                                                                    //TXT_UCW('DASHBOARD_TARGETS'),
                                                                    $displayWidth);

        // een extra regel voor de assessment cycle
        $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getReportInfo(  $displayWidth,
                                                                                $assessmentCycle,
                                                                                MESSAGE_WARNING);

        $additionalRow = BaseBlockHeaderRowInterfaceObject::create( $assessmentCycleInfo,
                                                                    $displayWidth);
        $additionalRow->setHiliteRow($doHilite);
        $additionalRow->setActionId(    self::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE);
        $additionalRow->setActionsWidth($selectorWidth);
        $additionalRow->addActionLink(   TargetReportInterfaceBuilderComponents::getEditAssessmentCycleLink());
        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        return $blockInterfaceObject->fetchHtml();
    }

    private static function getDashboardViewForBoss(  $displayWidth,
                                                      Array /* IdValue */ $keyIdValues,
                                                      TargetDashboardValueObject $valueObject)
    {
        $bossId = $valueObject->getBossId();

        $interfaceObject = TargetDashboardView::create( $valueObject,
                                                        $displayWidth);

        $totalDetailLink =
            TargetReportInterfaceBuilderComponents::getEmployeesTotalDetailLink($bossId,
                                                                                $valueObject->getEmployeesTotal());
        $interfaceObject->setTotalDetailLink($totalDetailLink);

        $withoutDetailLink =
            TargetReportInterfaceBuilderComponents::getStatusDetailLink($bossId,
                                                                        EmployeeTargetStatusValue::NO_TARGET,
                                                                        $valueObject->getEmployeesWithout());
        $interfaceObject->setWithoutDetailLink($withoutDetailLink);


        foreach($keyIdValues as $keyIdValue) {
            $key = $keyIdValue->getDatabaseId();
            $keyDetailLink =
                TargetReportInterfaceBuilderComponents::getStatusDetailLink($bossId,
                                                                            $key,
                                                                            $valueObject->getEmployeeCountForKey($key));

            $interfaceObject->setKeyDetailLink( $key,
                                                $keyDetailLink);
        }

        return $interfaceObject;
    }

}

?>
