<?php

/**
 * Description of AssessmentCycleInterfaceBuilder
 *
 * @author hans.prins
 */
require_once('modules/interface/builder/library/AssessmentCycleInterfaceBuilderComponents.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleDelete.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleEdit.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleDetail.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleInfoDetail.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleReportDetail.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleGroup.class.php');
require_once('modules/interface/interfaceobjects/library/AssessmentCycleView.class.php');

class AssessmentCycleInterfaceBuilder
{

    static function getViewHtml($displayWidth,
                                $hiliteId = NULL)
    {
        $valueObjects = AssessmentCycleService::getValueObjects();
        $currentCycle = AssessmentCycleService::getCurrentValueObject();

        // groep
        $groupInterfaceObject = AssessmentCycleGroup::create($displayWidth);
//        $groupInterfaceObject->setAddLink(  AssessmentCycleInterfaceBuilderComponents::getAddLink());

        // omzetten naar template data
        foreach($valueObjects as $valueObject) {
            $assessmentCycleId = $valueObject->getId();
            $interfaceObject = AssessmentCycleView::createWithValueObject(  $valueObject,
                                                                            $displayWidth);

            $interfaceObject->setHiliteRow(         $assessmentCycleId == $hiliteId);
            $interfaceObject->setIsCurrentCycle(    $assessmentCycleId == $currentCycle->getId());
            $interfaceObject->setEditLink(          AssessmentCycleInterfaceBuilderComponents::getEditLink($assessmentCycleId));
            $interfaceObject->setRemoveLink(        AssessmentCycleInterfaceBuilderComponents::getRemoveLink($assessmentCycleId));

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCF('MANAGE_ASSESSMENT_CYCLES'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   AssessmentCycleInterfaceBuilderComponents::getAddLink());

        return $blockInterfaceObject->fetchHtml();

    }

    static function getAddHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__ADD_ASSESSMENT_CYCLE);
        $safeFormHandler->addStringInputFormatType('cycle_name');
        $safeFormHandler->addDateInputFormatType(   'start_date');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = AssessmentCycleValueObject::createWithData(NULL);

        $interfaceObject = AssessmentCycleEdit::createWithValueObject(  $valueObject,
                                                                        $displayWidth);
        $interfaceObject->setStartDatePicker(   InterfaceBuilderComponents::getCalendarInputPopupHtml(  'start_date',
                                                                                                        DateUtils::getCurrentDatabaseDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getEditHtml($displayWidth,
                                $assessmentCycleId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__EDIT_ASSESSMENT_CYCLE);
        $safeFormHandler->storeSafeValue('assessmentCycleId', $assessmentCycleId);
        $safeFormHandler->addStringInputFormatType('cycle_name');
        $safeFormHandler->addDateInputFormatType('start_date');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = AssessmentCycleService::getValueObject($assessmentCycleId);

        $interfaceObject = AssessmentCycleEdit::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setStartDatePicker( InterfaceBuilderComponents::getCalendarInputPopupHtml('start_date',
                                                                                                    $valueObject->getStartDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml(  $displayWidth,
                                    $assessmentCycleId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ASSESSMENT_LIBRARY__DELETE_ASSESSMENT_CYCLE);

        $safeFormHandler->storeSafeValue('assessmentCycleId', $assessmentCycleId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = AssessmentCycleService::getValueObject($assessmentCycleId);

        $interfaceObject = AssessmentCycleDelete::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ASSESSMENT_CYCLE'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    static function getDetailHtml(  $displayWidth,
                                    AssessmentCycleValueObject $currentAssessmentCycle,
                                    AssessmentCycleValueObject $previousAssessmentCycle = NULL)
    {

        $detailInterfaceObject = self::getDetailInfo(   $displayWidth,
                                                        $currentAssessmentCycle,
                                                        $previousAssessmentCycle);

        $interfaceObject = AssessmentCycleDetail::createWithInterfaceObject($detailInterfaceObject,
                                                                            $displayWidth);

        return $interfaceObject->fetchHtml();
    }

    static function getDetailInfo(  $displayWidth,
                                    AssessmentCycleValueObject $currentAssessmentCycle,
                                    AssessmentCycleValueObject $previousAssessmentCycle = NULL)
    {
        $interfaceObject = AssessmentCycleInfoDetail::createWithValueObjects(   $currentAssessmentCycle,
                                                                                $previousAssessmentCycle,
                                                                                $displayWidth);

        $currentId = $currentAssessmentCycle->getId();
        if (!empty($currentId)) {
            if ($currentAssessmentCycle->hasEndDate()) {
                $currentTitle = DateConverter::display($currentAssessmentCycle->getStartDate()) . ' ' . TXT_LC('UNTIL') . ' ' . DateConverter::display($currentAssessmentCycle->getEndDate());
            } else {
                $currentTitle = TXT_LC('CYCLE_STARTS_ON') . ' ' . DateConverter::display($currentAssessmentCycle->getStartDate());
            }

        } else {
            $currentTitle = TXT_UCF('NO_ASSESSMENT_CYCLE');
        }
        $interfaceObject->setCurrentHoverIcon(AssessmentCycleInterfaceBuilderComponents::getHoverInformationIcon($currentId, $currentTitle));
        $previousId = empty($previousAssessmentCycle) ? NULL : $previousAssessmentCycle->getId();
        if (!empty($previousId)) {
            $previousTitle = DateConverter::display($previousAssessmentCycle->getStartDate()) . ' ' . TXT_LC('UNTIL') . ' ' . DateConverter::display($previousAssessmentCycle->getEndDate());
            $interfaceObject->setPreviousHoverIcon(AssessmentCycleInterfaceBuilderComponents::getHoverInformationIcon($previousId, $previousTitle));
        } else {
            $previousTitle = TXT_UCF('NO_ASSESSMENT_CYCLE');
        }

        $interfaceObject->setShowCyclePrefix($currentId != AssessmentCycleService::REPORT_USER_PERIOD_ID);
        $interfaceObject->setCurrentTitle($currentTitle);
        $interfaceObject->setpreviousTitle($previousTitle);

        return $interfaceObject;
    }

    /**
     *
     * @return AssessmentCycleReportDetail
     */
    static function getReportInfo(  $displayWidth,
                                    AssessmentCycleValueObject $reportAssessmentCycle,
                                    $notCurrentPrefixClass)
    {
        $currentAssessmentCycle     = AssessmentCycleService::getCurrentValueObject($today);
        $currentAssessmentCycleId   = $currentAssessmentCycle->getId();
        $reportId = $reportAssessmentCycle->getId();

        $interfaceObject = AssessmentCycleReportDetail::createWithValueObject(  $reportAssessmentCycle,
                                                                                $displayWidth);

        if (!empty($reportId)) {
            if ($reportAssessmentCycle->hasEndDate()) {
                $currentTitle = DateConverter::display($reportAssessmentCycle->getStartDate()) . ' ' . TXT_LC('UNTIL') . ' ' . DateConverter::display($reportAssessmentCycle->getEndDate());
            } else {
                $currentTitle = TXT_LC('CYCLE_STARTS_ON') . ' ' . DateConverter::display($reportAssessmentCycle->getStartDate());
            }
            $interfaceObject->setIsCurrentAssessmentCycle(  $currentAssessmentCycleId == $reportId);
        } else {
            $currentTitle = TXT_UCF('NO_ASSESSMENT_CYCLE');
        }

        $interfaceObject->setShowCyclePrefix($reportId != AssessmentCycleService::REPORT_USER_PERIOD_ID);
        $interfaceObject->setCurrentTitle($currentTitle);
        $interfaceObject->setPrefixClass( $interfaceObject->isCurrentAssessmentCycle() ? '' : $notCurrentPrefixClass);

        return $interfaceObject;
    }
}

?>
