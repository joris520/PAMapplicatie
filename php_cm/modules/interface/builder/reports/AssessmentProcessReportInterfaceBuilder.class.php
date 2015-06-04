<?php

/**
 * Description of AssessmentProcessReportInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilder.class.php');

require_once('modules/interface/builder/reports/AssessmentProcessReportInterfaceBuilderComponents.class.php');

require_once('modules/model/service/employee/EmployeeSelectService.class.php');
require_once('modules/model/service/report/AssessmentProcessReportService.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardCollection.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardValueObject.class.php');


require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardView.class.php');

require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardDetailGroup.class.php');
require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardDetailView.class.php');

require_once('modules/interface/converter/assessmentProcess/AssessmentProcessEvaluationRequestConverter.class.php');
require_once('modules/interface/converter/assessmentProcess/AssessmentProcessScoreRankingConverter.class.php');

class AssessmentProcessReportInterfaceBuilder extends BaseReportInterfaceBuilder
{
    const SHOW_TOTALS = true;
    const HIDE_TOTALS = false;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // invitations
    static function getDashboardViewHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            $showTotals,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            AssessmentProcessDashboardCollection $dashboardCollection)
    {
        $totalCountValueObject  = $dashboardCollection->getTotalCountValueObject();

        $groupInterfaceObject   = AssessmentProcessDashboardGroup::create(  $totalCountValueObject,
                                                                            $showTotals == self::SHOW_TOTALS,
                                                                            $displayWidth);


        // per leidinggevenden de medewerkers ophalen
        // allen, inclusief zonder leidinggevende
        $valueObjects = $dashboardCollection->getValueObjects();
        foreach($valueObjects as $valueObject) {
            $interfaceObject = self::getDashboardViewForBoss( $displayWidth,
                                                              $valueObject);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        if ($showTotals) {
            // de total links toevoegen
            // de BossFilterValue::IS_BOSS waarde "misbruiken"

            $invitedDetailLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardInvitationsDetailLink(   BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getInvitedTotal());
            // fasen
            $phaseInvitedDetailLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase1DetailLink( BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getPhaseInvited());
            $phaseSelectEvaluationLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase2DetailLink( BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getPhaseSelectEvaluation());
            $phaseEvaluationLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3DetailLink( BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getPhaseEvaluation());
            // details gesprekken
            $evaluationNotRequestedDetailLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3NoneDetailLink( BossFilterValue::IS_BOSS,
                                                                                                            $totalCountValueObject->getEvaluationNotRequested());
            $evaluationPlannedDetailLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3PlannedDetailLink(  BossFilterValue::IS_BOSS,
                                                                                                                $totalCountValueObject->getEvaluationPlanned());
            $evaluationReadyDetailLink =
                AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3ReadyDetailLink(BossFilterValue::IS_BOSS,
                                                                                                            $totalCountValueObject->getEvaluationReady());

            $groupInterfaceObject->setInvitedDetailLink($invitedDetailLink);
            $groupInterfaceObject->setPhaseInvitedDetailLink($phaseInvitedDetailLink);
            $groupInterfaceObject->setPhaseSelectEvaluationLink($phaseSelectEvaluationLink);
            $groupInterfaceObject->setPhaseEvaluationLink($phaseEvaluationLink);

            $groupInterfaceObject->setEvaluationNotRequestedDetailLink($evaluationNotRequestedDetailLink);
            $groupInterfaceObject->setEvaluationPlannedDetailLink($evaluationPlannedDetailLink);
            $groupInterfaceObject->setEvaluationReadyDetailLink($evaluationReadyDetailLink);
        }
        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('DASHBOARD_ASSESSMENT_PROCESS'),
                                                                    $displayWidth);

        // een extra regel voor de assessment cycle
        $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getReportInfo(  $displayWidth,
                                                                                $assessmentCycle,
                                                                                MESSAGE_WARNING);
        $additionalRow = BaseBlockHeaderRowInterfaceObject::create( $assessmentCycleInfo,
                                                                    $displayWidth);
        $additionalRow->setHiliteRow(   $doHilite);
        $additionalRow->setActionId(    self::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE);
        $additionalRow->setActionsWidth($selectorWidth);
        $additionalRow->addActionLink(  SelfAssessmentReportInterfaceBuilderComponents::getEditAssessmentCycleLink());
        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        return $blockInterfaceObject->fetchHtml();
    }

    private static function getDashboardViewForBoss(  $displayWidth,
                                                      AssessmentProcessDashboardValueObject $valueObject)
    {
        $bossId             = $valueObject->getBossId();
        $interfaceObject    = AssessmentProcessDashboardView::createWithValueObject($valueObject, $displayWidth);

        // uitgenodigd
        $invitedDetailLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardInvitationsDetailLink(   $bossId,
                                                                                                    $valueObject->getInvitedTotal());
        // fasen
        $phaseInvitedDetailLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase1DetailLink( $bossId,
                                                                                                    $valueObject->getPhaseInvited());
        $phaseSelectEvaluationLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase2DetailLink( $bossId,
                                                                                                    $valueObject->getPhaseSelectEvaluation());
        $phaseEvaluationLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3DetailLink( $bossId,
                                                                                                    $valueObject->getPhaseEvaluation());
        // details gesprekken
        $evaluationNotRequestedDetailLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3NoneDetailLink( $bossId,
                                                                                                        $valueObject->getEvaluationNotRequested());
        $evaluationPlannedDetailLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3PlannedDetailLink(  $bossId,
                                                                                                            $valueObject->getEvaluationPlanned());
        $evaluationReadyDetailLink =
            AssessmentProcessReportInterfaceBuilderComponents::getDashboardProcessPhase3ReadyDetailLink($bossId,
                                                                                                        $valueObject->getEvaluationReady());

        $interfaceObject->setInvitedDetailLink($invitedDetailLink);
        $interfaceObject->setPhaseInvitedDetailLink($phaseInvitedDetailLink);
        $interfaceObject->setPhaseSelectEvaluationLink($phaseSelectEvaluationLink);
        $interfaceObject->setPhaseEvaluationLink($phaseEvaluationLink);

        $interfaceObject->setEvaluationNotRequestedDetailLink($evaluationNotRequestedDetailLink);
        $interfaceObject->setEvaluationPlannedDetailLink($evaluationPlannedDetailLink);
        $interfaceObject->setEvaluationReadyDetailLink($evaluationReadyDetailLink);

        return $interfaceObject;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // popup details
    static function getDashboardDetailPhaseHtml($displayWidth,
                                                $bossId,
                                                /* AssessmentProcessStatusValue */ $assessmentProcessStatus,
                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $bossIdValue    = EmployeeSelectService::getBossIdValue($bossId);
        $bossName       = $bossIdValue->getValue();

        $reportEmployeeValueObjects = AssessmentProcessReportService::getAssessmentProcessDashboardPhaseDetail( $bossId,
                                                                                                                $assessmentProcessStatus,
                                                                                                                $assessmentCycle);

        $groupInterfaceObject = AssessmentProcessDashboardDetailGroup::create(  $bossName,
                                                                                $displayWidth);

        $groupInterfaceObject->setShowEvaluationDetails(    $assessmentProcessStatus == AssessmentProcessStatusValue::EVALUATION_SELECTED);
        $groupInterfaceObject->setShowSelectDetails(        true);
        $groupInterfaceObject->setShowCalculationDetails(   $assessmentProcessStatus == AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED);

        foreach ($reportEmployeeValueObjects as $reportEmployeeValueObject) {
            $interfaceObject = AssessmentProcessDashboardDetailView::createWithValueObject( $reportEmployeeValueObject,
                                                                                            $displayWidth);

            if ($assessmentProcessStatus == AssessmentProcessStatusValue::EVALUATION_SELECTED) {
                $isEvaluationRequested      = $reportEmployeeValueObject->isEvaluationRequested();
                $assessmentProcessStatus    = $reportEmployeeValueObject->getAssessmentProcessStatus();
                $assesmentEvaluationState   = AssessmentProcessEvaluationState::determineProcessEvaluationState(  $assessmentEvaluationStatus,
                                                                                                                $isEvaluationRequested,
                                                                                                                $assessmentProcessStatus);
                // status label
                $interfaceObject->setEvaluationStateLabel(  AssessmentProcessEvaluationStateConverter::display( $assesmentEvaluationState));

                $statusIcon = AssessmentProcessEvaluationState::determineEvaluationStatusIcon(  $assesmentEvaluationState);
                $title      = AssessmentEvaluationStatusConverter::display(                     $assessmentEvaluationStatus);
                $interfaceObject->setStatusIconView(   AssessmentIconView::create($statusIcon, $title));
            }
            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        return $groupInterfaceObject->fetchHtml();
    }

    static function getDashboardDetailEvaluationNoneHtml(   $displayWidth,
                                                            $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $bossIdValue    = EmployeeSelectService::getBossIdValue($bossId);
        $bossName       = $bossIdValue->getValue();

        $reportEmployeeValueObjects = AssessmentProcessReportService::getAssessmentProcessDashboardPhaseDetail( $bossId,
                                                                                                                AssessmentProcessStatusValue::EVALUATION_SELECTED,
                                                                                                                $assessmentCycle);

        $groupInterfaceObject = AssessmentProcessDashboardDetailGroup::create(  $bossName,
                                                                                $displayWidth);

        $groupInterfaceObject->setShowEvaluationDetails(    false);
        $groupInterfaceObject->setShowCalculationDetails(   true);

        foreach ($reportEmployeeValueObjects as $reportEmployeeValueObject) {
            if (!$reportEmployeeValueObject->isEvaluationRequested()) {
                $interfaceObject = AssessmentProcessDashboardDetailView::createWithValueObject( $reportEmployeeValueObject,
                                                                                                $displayWidth);
                $groupInterfaceObject->addInterfaceObject($interfaceObject);
            }
        }

        return $groupInterfaceObject->fetchHtml();
    }

    static function getDashboardDetailEvaluationPlannedHtml($displayWidth,
                                                            $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $bossIdValue    = EmployeeSelectService::getBossIdValue($bossId);
        $bossName       = $bossIdValue->getValue();

        $reportEmployeeValueObjects = AssessmentProcessReportService::getAssessmentProcessDashboardPhaseDetail( $bossId,
                                                                                                                AssessmentProcessStatusValue::EVALUATION_SELECTED,
                                                                                                                $assessmentCycle);

        $groupInterfaceObject = AssessmentProcessDashboardDetailGroup::create(  $bossName,
                                                                                $displayWidth);

        $groupInterfaceObject->setShowEvaluationDetails(    true);
        $groupInterfaceObject->setShowCalculationDetails(   true);

        foreach ($reportEmployeeValueObjects as $reportEmployeeValueObject) {
            if ($reportEmployeeValueObject->isEvaluationRequested()) {
                $interfaceObject = AssessmentProcessDashboardDetailView::createWithValueObject( $reportEmployeeValueObject,
                                                                                                $displayWidth);
                $groupInterfaceObject->addInterfaceObject($interfaceObject);
            }
        }

        return $groupInterfaceObject->fetchHtml();
    }

    static function getDashboardDetailEvaluationReadyHtml(  $displayWidth,
                                                            $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $bossIdValue = EmployeeSelectService::getBossIdValue($bossId);
        $bossName   = $bossIdValue->getValue();

        $reportEmployeeValueObjects = AssessmentProcessReportService::getAssessmentProcessDashboardPhaseDetail( $bossId,
                                                                                                                AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
                                                                                                                $assessmentCycle);
//die('getDashboardDetailEvaluationReadyHtml:'.print_r($reportEmployeeValueObjects,true));
        $groupInterfaceObject = AssessmentProcessDashboardDetailGroup::create(  $bossName,
                                                                                $displayWidth);

        $groupInterfaceObject->setShowEvaluationDetails(        false);
        $groupInterfaceObject->setShowCalculationDetails(       false);
        $groupInterfaceObject->setShowEvaluationStatusDetails(  true);

        foreach ($reportEmployeeValueObjects as $reportEmployeeValueObject) {
            $evaluationStatus = $reportEmployeeValueObject->getAssessmentEvaluationStatus();
            if (AssessmentEvaluationStatusValue::isValidValue($evaluationStatus))  {
                $interfaceObject = AssessmentProcessDashboardDetailView::createWithValueObject( $reportEmployeeValueObject,
                                                                                                $displayWidth);
                $groupInterfaceObject->addInterfaceObject($interfaceObject);
            }

        }

        return $groupInterfaceObject->fetchHtml();
    }
}

?>
