<?php

/**
 * Description of EmployeeListInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/list/EmployeeListInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/assessmentInvitation/AssessmentInvitationInterfaceBuilderComponents.class.php');

// service
require_once('modules/model/service/employee/profile/EmployeeProfileService.class.php');
require_once('modules/model/service/list/EmployeeFilterService.class.php');
require_once('application/library/ObjectSorter.class.php');

// state
require_once('modules/interface/state/EmployeeListState.class.php');
require_once('modules/interface/state/ScoreSelfAssessmentState.class.php');
require_once('modules/interface/state/AssessmentProcessEvaluationState.class.php');

// value
require_once('modules/interface/interfaceobjects/list/EmployeeListView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeListDelete.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultGroup.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultListView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultScoreStatusView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentProcessView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentProcessEvaluationView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentProcessEvaluationSelectView.class.php');

// converter

class EmployeeListInterfaceBuilder
{

    const REPLACE_HTML_ID               = 'search_employees_result';
    const CHECKBOX_HTML_ID_PREFIX       = 'check_evaluation_request_';
    const CHECKBOX_COLOR_HTML_ID_PREFIX = 'check_evaluation_request_background_';
    const CHECKBOX_COLOR_CLASS          = 'employee_conversation_manager_checked';

    const EMPLOYEE_NAME_HTML_ID         = 'linkempname';

    static function getViewHtml($displayWidth,
                                $listWidth,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        $interfaceObject = EmployeeListView::create($displayWidth);
        $interfaceObject->setReplaceHtmlId(         self::REPLACE_HTML_ID);
        $interfaceObject->setAddLink(               EmployeeListInterfaceBuilderComponents::getAddLink());
        $interfaceObject->setFilteredEmployees(     self::getResultContent( $listWidth,
                                                                            $assessmentCycle));

        return $interfaceObject->fetchHtml();

    }

    static function getRemoveHtml($displayWidth, $employeeId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__DELETE_PROFILE);

        $safeFormHandler->storeSafeValue('employeeId', $employeeId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject     = EmployeeProfileOrganisationService::getValueObject(  $employeeId,
                                                                                EmployeeProfileOrganisationService::INCLUDE_DETAILS);

        $interfaceObject = EmployeeListDelete::createWithValueObject(   $valueObject,
                                                                        $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_EMPLOYEE'));
        $interfaceObject->setRemoveInfo(        TXT_UCF('THE_EMPLOYEE_WILL_BE_PLACED_IN_THE_EMPLOYEE_ARCHIVE'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    static function getResultContentHtml($listWidth, AssessmentCycleValueObject $assessmentCycle)
    {
        $interfaceObject = self::getResultContent(  $listWidth,
                                                    $assessmentCycle);

        return $interfaceObject->fetchHtml();

    }

    static function getResultContent(   $listWidth,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        // afhankelijk van de gewenste extra informatie (score status, tsn assessment status etc)
        $filteredEmployeeIdValues = (array)EmployeeFilterService::getFilteredEmployeeIdValues();
        $sortMode = EmployeeFilterService::retrieveSortFilter();
        $assessmentFilter = EmployeeFilterService::retrieveAssessmentFilter();

        $listMode = EmployeeListState::determineState();
        switch ($listMode) {
            case EmployeeListState::SCORE_STATUS_ONLY:
                $interfaceObject = self::generateModeScoreStatusEmployees(  $listWidth,
                                                                            $filteredEmployeeIdValues,
                                                                            $assessmentCycle,
                                                                            $sortMode);
                break;
            case EmployeeListState::SELF_ASSESSMENT_NORMAL:
                $interfaceObject = self::generateModeSelfAssessmentEmployees(   $listWidth,
                                                                                $filteredEmployeeIdValues,
                                                                                $assessmentCycle,
                                                                                $sortMode,
                                                                                $assessmentFilter);
                break;
            case EmployeeListState::SELF_ASSESSMENT_PROCESS:
                $interfaceObject = self::generateModeSelfAssessmentProcessEmployees($listWidth,
                                                                                    $filteredEmployeeIdValues,
                                                                                    $assessmentCycle,
                                                                                    $sortMode,
                                                                                    $assessmentFilter);
                break;
            case EmployeeListState::LIST_EMPLOYEES:
            default:
                // EmployeeSortFilterValue::SORT_ALPHABETICAL
                $interfaceObject = self::generateModeListEmployees( $listWidth,
                                                                    $filteredEmployeeIdValues);
                break;
        }
        return $interfaceObject;
    }

    static function generateModeListEmployees(  $displayWidth,
                                                Array $filteredEmployeeIdValues)
    {
        // voor de gewone lijst is het voldoende om de IdValues op te halen
        $interfaceObject = EmployeeResultGroup::create( $displayWidth,
                                                        !PamApplication::isSingleUserLevel(),
                                                        CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT,
                                                        CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER);

        foreach($filteredEmployeeIdValues as $employeeIdValue) {
            $employeeId     = $employeeIdValue->getDatabaseId();
            $employeeName   = $employeeIdValue->getValue();

            $employeeView   = EmployeeResultListView::create(   $employeeId,
                                                                $employeeName,
                                                                EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                $displayWidth);

            $employeeView->setIsAllowedArrowKeys(   APPLICATION_EMPLOYEE_LIST_ARROW_KEYS);
            $employeeView->setIsSelected(           ApplicationNavigationService::isSelectedEmployeeId($employeeId));
            $employeeView->setSelectOnClick(        EmployeeListInterfaceBuilderComponents::getSelectOnClick($employeeId));

            $interfaceObject->addInterfaceObject($employeeView);
        }

        return $interfaceObject;
    }

    static function generateModeScoreStatusEmployees(   $displayWidth,
                                                        Array $filteredEmployeeIdValues,
                                                        AssessmentCycleValueObject $assessmentCycle,
                                                        $sortMode)
    {
        // de score status icoontjes tonen bij de medewerker
        $groupInterfaceObject = EmployeeResultGroup::create($displayWidth,
                                                            !PamApplication::isSingleUserLevel(),
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT,
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER);

        $objectSorterMode = ($sortMode == EmployeeSortFilterValue::SORT_ASSESSMENT_STATE) ? ObjectSorter::KEY_ORDER : ObjectSorter::INSERT_ORDER;
        $objectSorter = ObjectSorter::create($objectSorterMode);
        if ($objectSorterMode == ObjectSorter::KEY_ORDER) {
            $objectSorter->addSortKey(ScoreStatusValue::PRELIMINARY);
            $objectSorter->addSortKey(ScoreStatusValue::FINALIZED);
            $objectSorter->addSortKey(ScoreStatusValue::NONE);
        }

        foreach($filteredEmployeeIdValues as $employeeIdValue) {
            $employeeId     = $employeeIdValue->getDatabaseId();
            $employeeName   = $employeeIdValue->getValue();

            $assessmentValueObject = EmployeeAssessmentService::getValueObject( $employeeId,
                                                                                $assessmentCycle);
            $scoreStatus = $assessmentValueObject->getScoreStatus();

            // ander interface object voor EmployeeResultListView
            $employeeView = EmployeeResultScoreStatusView::create(  $employeeId,
                                                                    $employeeName,
                                                                    EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                    $displayWidth);
            // standaard waarden
            $employeeView->setIsAllowedArrowKeys(   APPLICATION_EMPLOYEE_LIST_ARROW_KEYS);
            $employeeView->setIsSelected(           ApplicationNavigationService::isSelectedEmployeeId($employeeId));
            $employeeView->setSelectOnClick(        EmployeeListInterfaceBuilderComponents::getSelectOnClick($employeeId));
            //$employeeView->setDeleteLink(   EmployeeListInterfaceBuilderComponents::getDeleteLink($employeeId));

            // score status specifiek
            list($managerTitle, $manangerIcon) = AssessmentInvitationInterfaceBuilderComponents::getScoreStatusDetails(true, $scoreStatus);
            $managerIconView = AssessmentIconView::create($manangerIcon, $managerTitle);
            $employeeView->setManagerIconView($managerIconView);

            // "handmatige" sortering...
            $sortKey = empty($scoreStatus) ? ScoreStatusValue::NONE : $scoreStatus;
            $objectSorter->addSortObject($sortKey, $employeeView);
        }
        $groupInterfaceObject->setInterfaceObjects($objectSorter->getSortedObjects());

        return $groupInterfaceObject;
    }

    static function generateModeSelfAssessmentEmployees($displayWidth,
                                                        Array $filteredEmployeeIdValues,
                                                        AssessmentCycleValueObject $assessmentCycle,
                                                        $sortMode,
                                                        $assessmentFilter)
    {
        // De icoontjes en status van de zelfevaluatie tonen
        $groupInterfaceObject = EmployeeResultGroup::create($displayWidth,
                                                            !PamApplication::isSingleUserLevel(),
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT,
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER);

        // sortering bepalen: ScoreSelfAssessmentState
        $objectSorterMode = ($sortMode == EmployeeSortFilterValue::SORT_ASSESSMENT_STATE) ? ObjectSorter::KEY_ORDER : ObjectSorter::INSERT_ORDER;
        $objectSorter = ObjectSorter::create($objectSorterMode);
        if ($objectSorterMode == ObjectSorter::KEY_ORDER) {
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::NONE);
        }

        // gefilterde employees ophalen
        foreach($filteredEmployeeIdValues as $employeeIdValue) {
            $employeeId     = $employeeIdValue->getDatabaseId();
            $employeeName   = $employeeIdValue->getValue();

            $assessmentCollection = EmployeeAssessmentService::getCollection(   $employeeId,
                                                                                $assessmentCycle);
            // de assessment ophalen
            $scoreSelfAssessmentState = ScoreSelfAssessmentState::determineState($assessmentCollection);

            if (EmployeeFilterService::matchAssessmentFilter($assessmentFilter, $scoreSelfAssessmentState,  AssessmentProcessEvaluationState::EVALUATION_NONE)) {
                // het interface object
                $employeeView = EmployeeResultSelfAssessmentView::create(   $employeeId,
                                                                            $employeeName,
                                                                            EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                            $displayWidth);
                // standaard waarden
                $employeeView->setIsAllowedArrowKeys(   APPLICATION_EMPLOYEE_LIST_ARROW_KEYS);
                $employeeView->setIsSelected(           ApplicationNavigationService::isSelectedEmployeeId($employeeId));
                $employeeView->setSelectOnClick(        EmployeeListInterfaceBuilderComponents::getSelectOnClick($employeeId));
                //$employeeView->setDeleteLink(   EmployeeListInterfaceBuilderComponents::getDeleteLink($employeeId));

                // score status specifiek
                $assessmentIconCollection = AssessmentIconCollection::create($assessmentCollection);
                $employeeView->setManagerIconView(  $assessmentIconCollection->getManagerIconView());
                $employeeView->setEmployeeIconView( $assessmentIconCollection->getEmployeeIconView());
                $employeeView->setStates(           $scoreStatus, $isInvited, $completedStatus, $scoreSelfAssessmentState);

                // "handmatige" sortering...
                $objectSorter->addSortObject(   $scoreSelfAssessmentState,
                                                $employeeView);
            }
        }
        // de hele gesorteerde lijst ophalen
        $groupInterfaceObject->setInterfaceObjects($objectSorter->getSortedObjects());

        return $groupInterfaceObject;
    }


    // TODO: process verwerken, integreren met handleModeSelfAssessmentEmployees ?
    static function generateModeSelfAssessmentProcessEmployees( $displayWidth,
                                                                Array $filteredEmployeeIdValues,
                                                                AssessmentCycleValueObject $assessmentCycle,
                                                                $sortMode,
                                                                $assessmentFilter)
    {
        // De icoontjes en status van de zelfevaluatie tonen
        $groupInterfaceObject = EmployeeResultGroup::create($displayWidth,
                                                            !PamApplication::isSingleUserLevel(),
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT,
                                                            CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER);

        // sortering bepalen: ScoreSelfAssessmentState
        $objectSorterMode = ($sortMode == EmployeeSortFilterValue::SORT_ASSESSMENT_STATE) ? ObjectSorter::KEY_ORDER : ObjectSorter::INSERT_ORDER;
        $objectSorter = ObjectSorter::create($objectSorterMode);
        if ($objectSorterMode == ObjectSorter::KEY_ORDER) {
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_COMPLETED);
            $objectSorter->addSortKey(ScoreSelfAssessmentState::NONE);
        }

        $employeeIdArray = array();
        foreach($filteredEmployeeIdValues as $filteredEmployeeIdValue) {
            $employeeIdArray[] = $filteredEmployeeIdValue->getDatabaseId();
        }
        $employeeIds = implode(',', $employeeIdArray);

        // TODO: optimalisatie: tweede parameter sturen door filter
        $employeeAssessmentProcessValueObjects = EmployeeAssessmentProcessService::getValueObjects( $employeeIds,
                                                                                                    AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
                                                                                                    $assessmentCycle,
                                                                                                    EmployeeAssessmentProcessService::USE_EMPLOYEE_ID_AS_KEY);

        // gefilterde employees ophalen
        foreach($filteredEmployeeIdValues as $employeeIdValue) {
            $employeeId     = $employeeIdValue->getDatabaseId();
            $employeeName   = $employeeIdValue->getValue();

            // het proces bekijken voor de juiste icoontjes voor de naam
            $processValueObject = $employeeAssessmentProcessValueObjects[$employeeId];

            // TODO: optimalisatie ophalen data, dus niet per employee!
            $assessmentCollection = EmployeeAssessmentService::getCollection(   $employeeId,
                                                                                $assessmentCycle);

            $scoreSelfAssessmentState = ScoreSelfAssessmentState::determineState($assessmentCollection);
            $assessmentEvaluationStatus = $assessmentCollection->getEvaluationStatus();
            $isEvaluationRequested = !empty($processValueObject) ? $processValueObject->isEvaluationRequested() : FALSE;
            $evaluationProcessState = AssessmentProcessEvaluationState::determineProcessEvaluationState($assessmentEvaluationStatus,
                                                                                                        $isEvaluationRequested);

            if (EmployeeFilterService::matchAssessmentFilter(   $assessmentFilter,
                                                                $scoreSelfAssessmentState,
                                                                $evaluationProcessState)) {



                $processStatus = !empty($processValueObject) ? $processValueObject->getAssessmentProcessStatus() : AssessmentProcessStatusValue::UNUSED;
                switch($processStatus) {
                    case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED: // zelfevaluatie niet meer in te vullen, scores berekend en gesprek uitnodinging aangevinkbaar
                        if ($assessmentEvaluationStatus != AssessmentEvaluationStatusValue::EVALUATION_DONE) {  // functioneringsgesprek gedaan: forceren als EVALUATION_READY door de break over te slaan

                            $employeeView = EmployeeResultSelfAssessmentProcessEvaluationSelectView::create($employeeId,
                                                                                                            $employeeName,
                                                                                                            EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                                                            $displayWidth);

                            $employeeView->setIsEvaluationRequested(  $processValueObject->isEvaluationRequested());
                            $employeeView->setScoreRank(            $processValueObject->getScoreRank());
                            $employeeView->setColor(                AssessmentProcessEvaluationState::determineRankColor( $processValueObject->getScoreRank(),
                                                                                                                        $processValueObject->isEvaluationRequested()));
                            $employeeView->setCheckBoxHtmlId(       self::CHECKBOX_HTML_ID_PREFIX);
                            $employeeView->setCheckBoxColorHtmlId(  self::CHECKBOX_COLOR_HTML_ID_PREFIX);
                            $employeeView->setCheckBoxOnClick(      EmployeeListInterfaceBuilderComponents::getEvaluationSelectOnClick($employeeId));
                            break;
                        }

                    case AssessmentProcessStatusValue::EVALUATION_SELECTED: // gesprekken geselecteerd of tevredenheidsbrief.
                        $employeeView = EmployeeResultSelfAssessmentProcessEvaluationView::create(  $employeeId,
                                                                                                    $employeeName,
                                                                                                    EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                                                    $displayWidth);

                        $statusIcon = AssessmentProcessEvaluationState::determineEvaluationStatusIcon(  $evaluationProcessState);
                        $title = AssessmentEvaluationStatusConverter::display($assessmentEvaluationStatus);
                        $employeeView->setStatusIconView(   AssessmentIconView::create($statusIcon, $title));
                        break;

                    case AssessmentProcessStatusValue::EVALUATION_READY:  // evaluatieproces afgerond (tevredenheidsbrief kan nu gestuurd worden?)
                        $employeeView = EmployeeResultSelfAssessmentProcessEvaluationView::create(  $employeeId,
                                                                                                    $employeeName,
                                                                                                    EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                                                    $displayWidth);

                        $employeeView->setStatusIconView(AssessmentIconView::create(ICON_EMPLOYEE_CONVERSATION_COMPLETED_10,'EVALUATION_READY'));
                        break;

                    case AssessmentProcessStatusValue::UNUSED:
                    case AssessmentProcessStatusValue::INVITED:
                    default:
                        $employeeView = EmployeeResultSelfAssessmentProcessView::create($employeeId,
                                                                                        $employeeName,
                                                                                        EmployeeListInterfaceBuilder::EMPLOYEE_NAME_HTML_ID,
                                                                                        $displayWidth);
                        // score status specifiek
                        $assessmentIconCollection = AssessmentIconCollection::create($assessmentCollection);
                        $employeeView->setManagerIconView($assessmentIconCollection->getManagerIconView());
                        $employeeView->setEmployeeIconView($assessmentIconCollection->getEmployeeIconView());
                }

                // standaard waarden
                $employeeView->setIsAllowedArrowKeys(   APPLICATION_EMPLOYEE_LIST_ARROW_KEYS);
                $employeeView->setIsSelected(           ApplicationNavigationService::isSelectedEmployeeId($employeeId));
                $employeeView->setSelectOnClick(        EmployeeListInterfaceBuilderComponents::getSelectOnClick($employeeId));
                //$employeeView->setDeleteLink(   EmployeeListInterfaceBuilderComponents::getDeleteLink($employeeId));

                // specifiek
                $employeeView->setStates(   $scoreStatus,
                                            $isInvited,
                                            $completedStatus,
                                            $scoreSelfAssessmentState);

                // "handmatige" sortering...
                $objectSorter->addSortObject(   $scoreSelfAssessmentState,
                                                $employeeView);
            }
        }
        // de hele gesorteerde lijst ophalen
        $groupInterfaceObject->setInterfaceObjects($objectSorter->getSortedObjects());

        return $groupInterfaceObject;
    }


}

?>
