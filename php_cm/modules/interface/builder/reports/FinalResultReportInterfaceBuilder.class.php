<?php

/**
 * Description of FinalResultReportInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportEmployeeInterfaceBuilder.class.php');

require_once('modules/interface/builder/reports/FinalResultReportInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/report/FinalResultDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/FinalResultDashboardView.class.php');

require_once('modules/interface/interfaceobjects/base/BaseBlockHeaderRowInterfaceObject.class.php');

class FinalResultReportInterfaceBuilder extends BaseReportEmployeeInterfaceBuilder
{
    const SHOW_TOTALS = true;
    const HIDE_TOTALS = false;

    static function getDashboardViewHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            $showTotals,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            FinalResultDashboardCollection $dashboardCollection)
    {

        $totalCountValueObject = $dashboardCollection->getTotalCountValueObject();
        $keyIdValues = $dashboardCollection->getKeyIdValues();

        $groupInterfaceObject = FinalResultDashboardGroup::create(  $totalCountValueObject,
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
                FinalResultReportInterfaceBuilderComponents::getEmployeesTotalDetailLink(   BossFilterValue::ALL,
                                                                                            $totalCountValueObject->getEmployeesTotal());
            $groupInterfaceObject->setTotalDetailLink($employeesTotalDetailLink);

            foreach($keyIdValues as $keyIdValue) {
                $key = $keyIdValue->getDatabaseId();
                $keyDetailLink =
                    FinalResultReportInterfaceBuilderComponents::getFinalResultScoreDetailLink( BossFilterValue::ALL,
                                                                                                $key,
                                                                                                $totalCountValueObject->getEmployeeCountForKey($key));

                $groupInterfaceObject->setKeyDetailLink($key, $keyDetailLink);
            }
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('DASHBOARD_FINAL_RESULT'),
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
        $additionalRow->addActionLink(   FinalResultReportInterfaceBuilderComponents::getEditAssessmentCycleLink());
        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        return $blockInterfaceObject->fetchHtml();

    }

    private static function getDashboardViewForBoss(  $displayWidth,
                                                      Array /* IdValue */ $keyIdValues,
                                                      FinalResultDashboardValueObject $valueObject)
    {
        $bossId = $valueObject->getBossId();

        $interfaceObject = FinalResultDashboardView::create($valueObject, $displayWidth);

        $employeesTotalDetailLink =
            FinalResultReportInterfaceBuilderComponents::getEmployeesTotalDetailLink(   $bossId,
                                                                                        $valueObject->getEmployeesTotal());
        $interfaceObject->setTotalDetailLink($employeesTotalDetailLink);

        foreach($keyIdValues as $keyIdValue) {
            $key = $keyIdValue->getDatabaseId();
            $keyDetailLink =
                FinalResultReportInterfaceBuilderComponents::getFinalResultScoreDetailLink( $bossId,
                                                                                            $key,
                                                                                            $valueObject->getEmployeeCountForKey($key));

            $interfaceObject->setKeyDetailLink($key, $keyDetailLink);
        }

        return $interfaceObject;
    }

}

?>
