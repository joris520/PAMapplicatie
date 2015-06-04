<?php

/**
 * Description of SelfAssessmentReportInterfaceBuilder
 *
 * @author ben.dokter
 */


require_once('modules/interface/builder/reports/BaseReportInterfaceBuilder.class.php');

require_once('modules/interface/builder/reports/SelfAssessmentReportInterfaceBuilderComponents.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentReportGroup.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentReportView.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentReportInvitationDetailView.class.php');

require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardView.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardDetailGroup.class.php');
require_once('modules/interface/interfaceobjects/report/SelfAssessmentDashboardDetailView.class.php');

require_once('modules/interface/interfaceobjects/report/EmployeeSelfAssessmentInvitationGroup.class.php');

require_once('modules/interface/converter/list/BossFilterConverter.class.php');
require_once('application/interface/converter/NameConverter.class.php');

require_once('modules/interface/converter/assessmentInvitation/AssessmentInvitationCompletedConverter.class.php');

require_once('modules/model/service/report/SelfAssessmentReportService.class.php');
require_once('modules/model/service/employee/EmployeeSelectService.class.php');


class SelfAssessmentReportInterfaceBuilder extends BaseReportInterfaceBuilder
{

    const NO_BOSS_STATUS = NULL;
    const NO_EMPLOYEE_STATUS = NULL;

    const GENERATE_EMPTY_GROUP  = true;
    const IGNORE_EMPTY_GROUP    = false;

    const SHOW_TOTALS = true;
    const HIDE_TOTALS = false;

    const DO_HIDE_LINKS = false;
    const DO_SHOW_LINKS = true;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // invitations
    static function getViewHtml($displayWidth,
                                $selectorWidth,
                                $doHilite,
                                Array $bossIdValues,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        $contentHtml = '';

        // todo: via groupInterfaceObject ivm mogelijk lege lijst
        // per leidinggevenden het interfaceobject met de medewerkers ophalen
        foreach($bossIdValues as $bossIdValue) {
            $interfaceObject = self::getReportGroupForBoss( $displayWidth,
                                                            $bossIdValue->getDatabaseId(),
                                                            $bossIdValue->getValue(),
                                                            $assessmentCycle,
                                                            self::DO_SHOW_LINKS);

            if (!is_null($interfaceObject)) {
                $contentHtml .= $interfaceObject->fetchHtml();
            }
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCW('REPORT_SELFASSESSMENT_INVITATIONS'),
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

        // todo: via groupInterfaceObject (voor nu: lege lijst opvangen)
        if (empty($contentHtml)) {
            $contentHtml = $blockInterfaceObject->displayEmptyMessage();
        }
        $blockInterfaceObject->setContentHtml($contentHtml);

        return $blockInterfaceObject->fetchHtml();

    }

    private static function getReportGroupForBoss(  $displayWidth,
                                                    $bossId,
                                                    $bossName,
                                                    AssessmentCycleValueObject $assessmentCycle,
                                                    $doShowLink)
    {
        $groupInterfaceObject = NULL;

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);

        if (!empty($allowedEmployeeIds)) {
            $invitationValueObjects = SelfAssessmentReportService::getValueObjects($allowedEmployeeIds, $assessmentCycle);

            if (count($invitationValueObjects) > 0) {
                $groupInterfaceObject = SelfAssessmentReportGroup::create($displayWidth, $bossName);

                $showLink = ($doShowLink == self::DO_SHOW_LINKS) ? SelfAssessmentReportView::SHOW_DETAIL_LINK: SelfAssessmentReportView::HIDE_DETAIL_LINK;
                foreach ($invitationValueObjects as $invitationValueObject) {
                    $interfaceObject = SelfAssessmentReportView::createWithValueObject( $invitationValueObject,
                                                                                        $assessmentCycle,
                                                                                        $displayWidth);

                    $interfaceObject->setShowLink(      $showLink);
                    $interfaceObject->setDetailLink(    SelfAssessmentReportInterfaceBuilderComponents::getInvitationDetailLink($invitationValueObject->getId(),
                                                                                                                                $invitationValueObject->getInvitationHash()));

                    $groupInterfaceObject->addInterfaceObject($interfaceObject);
                }
            }
        }
        return $groupInterfaceObject;
    }

    static function getDetailHtml(  $displayWidth,
                                    $employeeId,
                                    $invitationHash)
    {
        $detailHtml = '';

        if (EmployeeSelectService::isAllowedEmployeeId($employeeId)) {
            $valueObject = SelfAssessmentReportService::getEmployeeInvitationDetailValueObject( $employeeId,
                                                                                                $invitationHash);

            $interfaceObject = SelfAssessmentReportInvitationDetailView::createWithValueObject( $valueObject,
                                                                                                $displayWidth);
            $invitationHasLink = SelfAssessmentReportInterfaceBuilderComponents::getInvitationHashLink( $valueObject->getInvitationHash());
            $interfaceObject->setInvitationHashLink($invitationHasLink);


            $detailHtml = $interfaceObject->fetchHtml();
        }

        return $detailHtml;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // dashboard
    static function getDashboardViewHtml(   $displayWidth,
                                            $selectorWidth,
                                            $doHilite,
                                            $showTotals,
                                            AssessmentCycleValueObject $assessmentCycle,
                                            SelfAssessmentDashboardCollection $dashboardCollection)
    {
        $totalCountValueObject = $dashboardCollection->getTotalCountValueObject();

        $groupInterfaceObject = SelfAssessmentDashboardGroup::create(   $totalCountValueObject,
                                                                        $showTotals == self::SHOW_TOTALS,
                                                                        $displayWidth);

        // per leidinggevenden de medewerkers ophalen
        // allen, inclusief zonder leidinggevende
        $valueObjects = $dashboardCollection->getValueObjects();
        foreach($valueObjects as $valueObject) {
            $interfaceObject = self::getDashboardViewForBoss(   $displayWidth,
                                                                $valueObject);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        if ($showTotals) {
            // de total links toevoegen
            // de BossFilterValue::IS_BOSS waarde "misbruiken"
            $invitedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardInvitationsDetailLink(  BossFilterValue::IS_BOSS,
                                                                                                    $totalCountValueObject->getInvitedTotal());
            $employeeNotCompletedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardEmployeeNotCompletedDetailLink( BossFilterValue::IS_BOSS,
                                                                                                            $totalCountValueObject->getEmployeeNotCompleted());
            $employeeCompletedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardEmployeeCompletedDetailLink(BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getEmployeeCompleted());
            $bossNotCompletedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardBossNotCompletedDetailLink( BossFilterValue::IS_BOSS,
                                                                                                        $totalCountValueObject->getBossNotCompleted());
            $bossCompletedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardBossCompletedDetailLink(BossFilterValue::IS_BOSS,
                                                                                                    $totalCountValueObject->getBossCompleted());
            $bothCompletedDetailLink =
                SelfAssessmentReportInterfaceBuilderComponents::getDashboardFullCompletedDetailLink(BossFilterValue::IS_BOSS,
                                                                                                    $totalCountValueObject->getBothCompleted());

            $groupInterfaceObject->setInvitedDetailLink($invitedDetailLink);
            $groupInterfaceObject->setEmployeeNotCompletedDetailLink($employeeNotCompletedDetailLink);
            $groupInterfaceObject->setEmployeeCompletedDetailLink($employeeCompletedDetailLink);
            $groupInterfaceObject->setBossNotCompletedDetailLink($bossNotCompletedDetailLink);
            $groupInterfaceObject->setBossCompletedDetailLink($bossCompletedDetailLink);
            $groupInterfaceObject->setBothCompletedDetailLink($bothCompletedDetailLink);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCW('DASHBOARD_ASSESSMENT_COMPLETED'),
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
        $additionalRow->addActionLink(   SelfAssessmentReportInterfaceBuilderComponents::getEditAssessmentCycleLink());
        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        return $blockInterfaceObject->fetchHtml();
    }


    private static function getDashboardViewForBoss($displayWidth,
                                                    SelfAssessmentDashboardValueObject $valueObject)
    {
        $interfaceObject = SelfAssessmentDashboardView::create($valueObject, $displayWidth);

        $bossId = $valueObject->getBossId();

        $invitedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardInvitationsDetailLink(  $bossId,
                                                                                                $valueObject->getInvitedTotal());
        $employeeNotCompletedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardEmployeeNotCompletedDetailLink( $bossId,
                                                                                                        $valueObject->getEmployeeNotCompleted());
        $employeeCompletedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardEmployeeCompletedDetailLink($bossId,
                                                                                                    $valueObject->getEmployeeCompleted());
        $bossNotCompletedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardBossNotCompletedDetailLink( $bossId,
                                                                                                    $valueObject->getBossNotCompleted());
        $bossCompletedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardBossCompletedDetailLink($bossId,
                                                                                                $valueObject->getBossCompleted());
        $bothCompletedDetailLink =
            SelfAssessmentReportInterfaceBuilderComponents::getDashboardFullCompletedDetailLink($bossId,
                                                                                                $valueObject->getBothCompleted());

        $interfaceObject->setInvitedDetailLink($invitedDetailLink);
        $interfaceObject->setEmployeeNotCompletedDetailLink($employeeNotCompletedDetailLink);
        $interfaceObject->setEmployeeCompletedDetailLink($employeeCompletedDetailLink);
        $interfaceObject->setBossNotCompletedDetailLink($bossNotCompletedDetailLink);
        $interfaceObject->setBossCompletedDetailLink($bossCompletedDetailLink);
        $interfaceObject->setBothCompletedDetailLink($bothCompletedDetailLink);

        return $interfaceObject;
    }

    static function getDashboardDetailInvitationsHtml(  $displayWidth,
                                                        $bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $html = '';
        // de total links "misbruiken" de BossFilterValue::IS_BOSS waarde
        if ($bossId == BossFilterValue::IS_BOSS) {
            // allen, inclusief zonder leidinggevende
            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            foreach($bossIdValues as $bossIdValue) {
                $html .= self::generateDashboardDetailInvitationsHtml(  $displayWidth,
                                                                        $bossIdValue->getDatabaseId(),
                                                                        $bossIdValue->getValue(),
                                                                        $assessmentCycle,
                                                                        self::IGNORE_EMPTY_GROUP);
            }
        } else {
            $bossIdValue    = EmployeeSelectService::getBossIdValue($bossId);
            $bossName       = $bossIdValue->getValue();
            $html = self::generateDashboardDetailInvitationsHtml(   $displayWidth,
                                                                    $bossId,
                                                                    $bossName,
                                                                    $assessmentCycle,
                                                                    self::GENERATE_EMPTY_GROUP);
        }

        return $html;
    }

    private static function generateDashboardDetailInvitationsHtml( $displayWidth,
                                                                    $bossId,
                                                                    $bossName,
                                                                    AssessmentCycleValueObject $assessmentCycle,
                                                                    $generateEmptyGroup)
    {
        $html = '';

        $interfaceObject = self::getReportGroupForBoss( $displayWidth,
                                                        $bossId,
                                                        $bossName,
                                                        $assessmentCycle,
                                                        self::DO_HIDE_LINKS);

        if (!is_null($interfaceObject) &&
            ($generateEmptyGroup == self::GENERATE_EMPTY_GROUP || $interfaceObject->getCount() > 0)) {

            $html = $interfaceObject->fetchHtml();
        }
        return $html;
    }

    static function getDashboardDetailEmployeeStatusHtml(  $displayWidth,
                                                           $bossId,
                                                           $completedStatus,
                                                           AssessmentCycleValueObject $assessmentCycle)
    {
        return self::getDashboardDetailStatusHtml(  $displayWidth,
                                                    $bossId,
                                                    $assessmentCycle,
                                                    $completedStatus,
                                                    self::NO_BOSS_STATUS);
    }



    static function getDashboardDetailBossStatusHtml(   $displayWidth,
                                                        $bossId,
                                                        $scoreStatus,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        return self::getDashboardDetailStatusHtml(  $displayWidth,
                                                    $bossId,
                                                    $assessmentCycle,
                                                    self::NO_EMPLOYEE_STATUS,
                                                    $scoreStatus);
    }

    static function getDashboardDetailFullCompletedHtml($displayWidth,
                                                        $bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        return self::getDashboardDetailStatusHtml(  $displayWidth,
                                                    $bossId,
                                                    $assessmentCycle,
                                                    AssessmentInvitationCompletedValue::COMPLETED,
                                                    ScoreStatusValue::FINALIZED);
    }

    private static function getDashboardDetailStatusHtml(   $displayWidth,
                                                            $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle,
                                                            $completedStatusFilter,
                                                            $scoreStatusFilter)
    {
        $html = '';

        if ($bossId == BossFilterValue::IS_BOSS) {
            // allen, inclusief zonder leidinggevende
            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            foreach($bossIdValues as $bossIdValue) {
                $html .= self::generateDashboardDetailStatusHtml(   $displayWidth,
                                                                    $bossIdValue->getDatabaseId(),
                                                                    $bossIdValue->getValue(),
                                                                    $assessmentCycle,
                                                                    $completedStatusFilter,
                                                                    $scoreStatusFilter,
                                                                    self::IGNORE_EMPTY_GROUP);

            }
        } else {
            $bossIdValue = EmployeeSelectService::getBossIdValue($bossId);
            $html = self::generateDashboardDetailStatusHtml($displayWidth,
                                                            $bossId,
                                                            $bossIdValue->getValue(),
                                                            $assessmentCycle,
                                                            $completedStatusFilter,
                                                            $scoreStatusFilter,
                                                            self::GENERATE_EMPTY_GROUP);
        }
        return $html;
    }

    private static function generateDashboardDetailStatusHtml(  $displayWidth,
                                                                $bossId,
                                                                $bossName,
                                                                AssessmentCycleValueObject $assessmentCycle,
                                                                $completedStatusFilter,
                                                                $scoreStatusFilter,
                                                                $generateEmptyGroup)
    {
        $html = '';
        $groupInterfaceObject = SelfAssessmentDashboardDetailGroup::create($bossName, $displayWidth);
        $groupInterfaceObject->setShowBossStatus(!is_null($scoreStatusFilter));
        $groupInterfaceObject->setShowEmployeeStatus(!is_null($completedStatusFilter));
        $groupInterfaceObject->setShowDetails(is_null($completedStatusFilter) || is_null($scoreStatusFilter));
        $groupInterfaceObject->setShowEmployeeCompleted($completedStatusFilter != AssessmentInvitationCompletedValue::NOT_COMPLETED);
        self::getDashboardReportDetailView( $displayWidth,
                                            $bossId,
                                            $groupInterfaceObject,
                                            $assessmentCycle,
                                            $completedStatusFilter,
                                            $scoreStatusFilter);

        if ($generateEmptyGroup == self::GENERATE_EMPTY_GROUP || $groupInterfaceObject->getCount() > 0) {
            $html = $groupInterfaceObject->fetchHtml();
        }
        return $html;
    }

    static function getDashboardTotalsDetailHtml(   $displayWidth,
                                                    AssessmentCycleValueObject $assessmentCycle,
                                                    $completedStatusFilter,
                                                    $scoreStatusFilter)
    {
        $bossIdValue = EmployeeSelectService::getBossIdValue($bossId);
        $bossName   = $bossIdValue->getValue();

        $groupInterfaceObject = SelfAssessmentDashboardDetailGroup::create($bossName, $displayWidth);
        $groupInterfaceObject->setShowBossStatus(!is_null($scoreStatusFilter));
        $groupInterfaceObject->setShowEmployeeStatus(!is_null($completedStatusFilter));
        $groupInterfaceObject->setShowDetails(is_null($completedStatusFilter) || is_null($scoreStatusFilter));
        $groupInterfaceObject->setShowEmployeeCompleted($completedStatusFilter != AssessmentInvitationCompletedValue::NOT_COMPLETED);

        self::getDashboardReportDetailView( $displayWidth,
                                            $bossId,
                                            $groupInterfaceObject,
                                            $assessmentCycle,
                                            $completedStatusFilter,
                                            $scoreStatusFilter);


        return $groupInterfaceObject = SelfAssessmentDashboardDetailGroup::create($bossName, $displayWidth);
        $groupInterfaceObject->fetchHtml();
    }


    private function getDashboardReportDetailView(  $displayWidth,
                                                    $bossId,
                                                    SelfAssessmentDashboardDetailGroup &$groupInterfaceObject,
                                                    AssessmentCycleValueObject $assessmentCycle,
                                                    $completedStatusFilter,
                                                    $scoreStatusFilter)
    {
        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);
        if (!empty($allowedEmployeeIds)) {
            $invitationValueObjects = SelfAssessmentReportService::getValueObjects($allowedEmployeeIds, $assessmentCycle);
            if (count($invitationValueObjects) > 0) {

                foreach ($invitationValueObjects as $invitationValueObject) {
                    $employeeId = $invitationValueObject->getId();
                    $assessmentValueObject = EmployeeAssessmentService::getValueObject($employeeId, $assessmentCycle);

                    // alleen gefilterde toevoegen
                    if  (   (!is_null($completedStatusFilter) && is_null($scoreStatusFilter)        && $invitationValueObject->getCompletedStatus() == $completedStatusFilter) ||
                            (!is_null($scoreStatusFilter)     && is_null($completedStatusFilter)    && $assessmentValueObject->getScoreStatus() == $scoreStatusFilter) ||
                            (!is_null($completedStatusFilter)   && $invitationValueObject->getCompletedStatus() == $completedStatusFilter &&
                             !is_null($scoreStatusFilter)       && $assessmentValueObject->getScoreStatus() == $scoreStatusFilter)
                        ) {
                        $interfaceObject = SelfAssessmentDashboardDetailView::createWithValueObject(    $invitationValueObject,
                                                                                                        $assessmentValueObject,
                                                                                                        $displayWidth);
                        $groupInterfaceObject->addInterfaceObject($interfaceObject);
                    }
                }

            }
        }
        //return $groupInterfaceObject;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // overzicht voor op het employee tabblad
    static function getEmployeeViewHtml($displayWidth, $employeeId)
    {
        $groupInterfaceObject = EmployeeSelfAssessmentInvitationGroup::create($displayWidth);

        $valueObjects = SelfAssessmentReportService::getEmployeeInvitationValueObjects($employeeId);
        foreach ($valueObjects as $valueObject) {
            $assessmentCycle = AssessmentCycleService::getCurrentValueObject(   $valueObject->getDateInvited());

            $interfaceObject = SelfAssessmentReportView::createWithValueObject( $valueObject, $assessmentCycle, $displayWidth);

            $detailLink = SelfAssessmentReportInterfaceBuilderComponents::getInvitationDetailLink(  $valueObject->getId(),
                                                                                                    $valueObject->getInvitationHash());
            $interfaceObject->setDetailLink($detailLink);
            $interfaceObject->setShowLink(  SelfAssessmentReportView::SHOW_DETAIL_LINK);

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        return $groupInterfaceObject->fetchHtml();
    }

}

?>
