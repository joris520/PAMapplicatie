<?php

// components
require_once('modules/interface/builder/employee/competence/EmployeeScoreInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/library/CompetenceInterfaceBuilderComponents.class.php');

// services
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeSelfAssessmentScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeJobProfileService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');

// display conversies
require_once('application/interface/converter/DateConverter.class.php');
require_once('application/interface/converter/DateTimeConverter.class.php');
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');
require_once('modules/interface/converter/library/competence/NormConverter.class.php');
require_once('modules/interface/converter/library/competence/CategoryConverter.class.php');

// interface objects

require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceGroupEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceCategoryGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceClusterGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreView.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreHistory.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceGroupEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceCategoryGroupEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceClusterGroupEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreEdit.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreGroupEdit.class.php');


class EmployeeScoreInterfaceBuilder
{

    const COMPETENCE_NOTE_VIEW_HTML_ID          = 'competence_toggle_view_notes_block';
    const COMPETENCE_NOTE_VIEW_PREFIX           = 'view_comment_row_';
    const COMPETENCE_NOTE_VIEW_INITIAL_VISIBLE  = FALSE;
    const COMPETENCE_NOTE_EDIT_HTML_ID          = 'competence_toggle_edit_notes_block';
    const COMPETENCE_NOTE_EDIT_PREFIX           = 'edit_comment_row_';
    const COMPETENCE_NOTE_EDIT_INITIAL_VISIBLE  = FALSE;

    const COMPETENCE_SCORE_EDIT_WIDTH_TEXT      = 500;
    const COMPETENCE_SCORE_EDIT_WIDTH_NUMERIC   = 350;
    const COMPETENCE_SCORE_EDIT_ACTIONS         = 50;



    // TODO: scoreCollections in clusterCollection opnemen
    static function getViewHtml($displayWidth,
                                $employeeId,
                                $hiliteClusterId,
                                EmployeeCompetenceCategoryClusterScoreCollection $currentCategoryCollection,
                                EmployeeCompetenceCategoryClusterScoreCollection $previousCategoryCollection,
                                AssessmentIconCollection $assessmentIconCollection,
                                AssessmentIconCollection $previousAssessmentIconCollection)
    {

        $showCategory       = CUSTOMER_OPTION_SHOW_KS;
        $showBossRemarks    = CUSTOMER_OPTION_USE_SKILL_NOTES;
        $show360            = CUSTOMER_OPTION_SHOW_360;
        $show360Remarks     = CUSTOMER_OPTION_SHOW_360 && CUSTOMER_OPTION_SHOW_360_REMARKS;
        $showNorm           = CUSTOMER_OPTION_SHOW_NORM;
        $showWeight         = CUSTOMER_OPTION_SHOW_WEIGHT;
        $showPdpActions     = CUSTOMER_OPTION_SHOW_ACTIONS && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS);

        $showAnyRemarks = $showBossRemarks || $show360Remarks;

        $isAllowedEditCurrentScore  =   EmployeeCompetenceService::isAllowedEditManagerScore($employeeId);

        $categoryIds = $currentCategoryCollection->getCategoryIds();
        $hasCategories = count($categoryIds) > 0;
        if (!$hasCategories) {
            $competenceInterfaceObject = EmployeeCompetenceGroup::create($displayWidth);
            $competenceInterfaceObject->setEmptyMessage( TXT_UCF('NO_COMPETENCE_RETURN'));
        } else {
            // current score
            $currentPeriod              = $currentCategoryCollection->getAssessmentCycle();
            $scoreStatusValue           = $currentCategoryCollection->getScoreStatusValue();

            $assessmentCollection           = $assessmentIconCollection->getAssessmentCollection();
            $currentIsInvited               = $assessmentCollection->isInvited();

            $previousAssessmentCollection   = $previousAssessmentIconCollection->getAssessmentCollection();
            $previousIsInvited              = $previousAssessmentCollection->isInvited();

            $isAllowedViewCurrentScore          = EmployeeCompetenceService::isAllowedViewManagerScore($employeeId, $scoreStatusValue);
            $isAllowedViewCurrentEmployeeScore  = EmployeeCompetenceService::isAllowedViewEmployeeScore($employeeId, $scoreStatusValue);

            // previous score
            $previousPeriod             = $previousCategoryCollection->getAssessmentCycle();
            $previousScoreStatusValue   = $previousCategoryCollection->getScoreStatusValue();

            $isAllowedViewPreviousScore         = EmployeeCompetenceService::isAllowedViewManagerScore($employeeId, $previousScoreStatusValue);
            $isAllowedViewPreviousEmployeeScore = EmployeeCompetenceService::isAllowedViewEmployeeScore($employeeId, $previousScoreStatusValue);

            $competenceInterfaceObject = EmployeeCompetenceGroup::create($displayWidth);
            $competenceInterfaceObject->setToggleNotesHtmlId(   self::COMPETENCE_NOTE_VIEW_HTML_ID);

            // elke category langslopen
            foreach($categoryIds as $categoryId) {
                $categoryName = $currentCategoryCollection->getCategoryName($categoryId);
                // interface object per category
                $categoryInterfaceObject = EmployeeCompetenceCategoryGroup::create($displayWidth, $categoryName);
                $categoryInterfaceObject->setShowCategory(              $showCategory);
                $categoryInterfaceObject->setShowAnyRemarks(            $showAnyRemarks);
                $categoryInterfaceObject->setShow360(                   $show360);
                $categoryInterfaceObject->setShowNorm(                  $showNorm);
                $categoryInterfaceObject->setShowWeight(                $showWeight);
                $categoryInterfaceObject->setShowPdpActions(            $showPdpActions);

                $categoryInterfaceObject->setPeriodNames(               $currentPeriod->getAssessmentCycleName(),
                                                                        $previousPeriod->getAssessmentCycleName());
                $categoryInterfaceObject->setPeriodIconViews(           $assessmentIconCollection->getManagerIconView(),
                                                                        $previousAssessmentIconCollection->getManagerIconView());
                $categoryInterfaceObject->setPeriodEmployeeIconViews(   $assessmentIconCollection->getEmployeeIconView(),
                                                                        $previousAssessmentIconCollection->getEmployeeIconView());

                // alle clusters in de category verwerkern
                $categoryClusterIds = $currentCategoryCollection->getCategoryClusterIds($categoryId);
                foreach($categoryClusterIds as $clusterId) {
                    $clusterScoreCollection                 = $currentCategoryCollection->getEmployeeClusterScoreCollection(    $categoryId,
                                                                                                                                $clusterId);
                    $currentScoreCollections                = $clusterScoreCollection->getEmployeeScoreCollections();

                    $previousClusterScoreCollection         = $previousCategoryCollection->getEmployeeClusterScoreCollection(   $categoryId,
                                                                                                                                $clusterId);
                    $previousScoreCollectionsByCompetence   = $previousClusterScoreCollection->getEmployeeCompetenceScoreCollections();

                    $clusterName    = $clusterScoreCollection->getClusterName($clusterId);

                    // interface object per cluster
                    $clusterInterfaceObject = EmployeeCompetenceClusterGroup::create(   $displayWidth,
                                                                                        $categoryId,
                                                                                        $categoryName,
                                                                                        $clusterId,
                                                                                        $clusterName);

                    $clusterInterfaceObject->setEditLink(       EmployeeScoreInterfaceBuilderComponents::getEditClusterLink($employeeId,
                                                                                                                            $clusterId,
                                                                                                                            $isAllowedEditCurrentScore));

                    $clusterInterfaceObject->setHiliteCluster(  $hiliteClusterId == $clusterId);

                    // alle score collecties in het cluster verwerken
                    $isFirst = true;
                    foreach($currentScoreCollections as $scoreCollection) {

                        $employeeCompetenceValueObject  = $scoreCollection->getCompetenceValueObject();
                        $competenceId = $employeeCompetenceValueObject->getCompetenceId();
                        if ($isFirst) {
                            $isFirst = false;
                            $clusterHasMainCompetence = CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE && $employeeCompetenceValueObject->getCompetenceIsMain() == COMPETENCE_CLUSTER_IS_MAIN;
                            $clusterInterfaceObject->setClusterHasMainCompetence($clusterHasMainCompetence);
                        }

                        $previousScoreCollection = $previousScoreCollectionsByCompetence[$competenceId];

                        $currentScoreValueObject                = $scoreCollection->getScoreValueObject();
                        $currentSelfAssessmentScoreValueObject  = $scoreCollection->getSelfAssessmentScoreValueObject();
                        $previousScoreValueObject               = $previousScoreCollection->getScoreValueObject();
                        $previousSelfAssessmentScoreValueObject = $previousScoreCollection->getSelfAssessmentScoreValueObject();

                        $hasDisplayableNotes =  ($isAllowedViewCurrentScore     && $currentScoreValueObject->hasNote()) ||
                                                ($isAllowedViewPreviousScore    && $previousScoreValueObject->hasNote());

                        // interface object per score
                        $interfaceObject = EmployeeCompetenceScoreView::createWithValueObjects( $employeeCompetenceValueObject,
                                                                                                $currentScoreValueObject,
                                                                                                $previousScoreValueObject,
                                                                                                $displayWidth);
                        $interfaceObject->setShowAnyRemarks(    $showAnyRemarks);
                        $interfaceObject->setShowBossRemarks(   $showBossRemarks);
                        $interfaceObject->setShow360Remarks(    $show360Remarks);
                        $interfaceObject->setShow360(           $show360);
                        $interfaceObject->setShowNorm(          $showNorm);
                        $interfaceObject->setShowWeight(        $showWeight);
                        $interfaceObject->setShowPdpActions(    $showPdpActions);
                        if ($show360) {
                            $hasDisplayableNotes = $hasDisplayableNotes ||
                                        ($isAllowedViewCurrentEmployeeScore     && $currentSelfAssessmentScoreValueObject->hasNote()) ||
                                        ($isAllowedViewPreviousEmployeeScore    && $previousSelfAssessmentScoreValueObject->hasNote());

                            $interfaceObject->setCurrentSelfAssessmentScoreValueObject( $currentSelfAssessmentScoreValueObject);
                            $interfaceObject->setPreviousSelfAssessmentScoreValueObject($previousSelfAssessmentScoreValueObject);
                        }

                        $interfaceObject->setHasNotes(                          $hasDisplayableNotes);
                        $interfaceObject->setHasClusterMainCompetence(          $clusterInterfaceObject->getClusterHasMainCompetence());
                        // competentie
                        $interfaceObject->setSymbolIsKeyCompetence(             $employeeCompetenceValueObject->competenceIsKey ? SIGN_IS_KEY_COMP : SIGN_IS_NOT_KEY_COMP);
                        $interfaceObject->setSymbolIsAdditionalCompetence(      $employeeCompetenceValueObject->competenceFunctionIsMain ? '' : SIGN_COMP_ADDITIONAL_PROFILE);
                        // employee scores
                        $interfaceObject->setIsAllowedViewCurrentScore(         $isAllowedViewCurrentScore);
                        $interfaceObject->setIsAllowedViewCurrentEmployeeScore( $isAllowedViewCurrentEmployeeScore, $currentIsInvited);
                        if ($isAllowedViewCurrentScore && $isAllowedViewCurrentEmployeeScore) {
                            $interfaceObject->setCurrentDiffIndicator(          EmployeeScoreInterfaceBuilderComponents::diffIndicator( $currentScoreValueObject,
                                                                                                                                        $currentSelfAssessmentScoreValueObject));
                        }
                        $interfaceObject->setIsAllowedViewPreviousScore(        $isAllowedViewPreviousScore);
                        $interfaceObject->setIsAllowedViewPreviousEmployeeScore($isAllowedViewPreviousEmployeeScore, $previousIsInvited);

                        if ($isAllowedViewPreviousScore && $isAllowedViewPreviousEmployeeScore) {
                            $interfaceObject->setPreviousDiffIndicator(         EmployeeScoreInterfaceBuilderComponents::diffIndicator( $previousScoreValueObject,
                                                                                                                                        $previousSelfAssessmentScoreValueObject));
                        }
                        // acties
                        $interfaceObject->setIsInitialVisibleNotes(             self::COMPETENCE_NOTE_VIEW_INITIAL_VISIBLE);
                        $interfaceObject->setToggleNotePrefixId(                self::COMPETENCE_NOTE_VIEW_PREFIX);
                        $interfaceObject->setToggleNoteVisibilityLink(          EmployeeScoreInterfaceBuilderComponents::getToggleViewNoteVisibilityLink(   self::COMPETENCE_NOTE_VIEW_HTML_ID,
                                                                                                                                                            self::COMPETENCE_NOTE_VIEW_PREFIX,
                                                                                                                                                            $competenceId));

                        $interfaceObject->setHistoryLink(   EmployeeScoreInterfaceBuilderComponents::getHistoryLink($employeeId,
                                                                                                                    $competenceId,
                                                                                                                    $isAllowedViewCurrentScore));
                        $interfaceObject->setDetailLinkId(  CompetenceInterfaceBuilderComponents::getDetailLinkId($competenceId));
                        $interfaceObject->setDetailOnClick( CompetenceInterfaceBuilderComponents::getShowDetailOnClick( $competenceId,
                                                                                                                        CompetenceInterfaceBuilder::DISPLAY_MODE_NORMAL));

                        $clusterInterfaceObject->addInterfaceObject($interfaceObject);
                    }
                    $categoryInterfaceObject->addInterfaceObject($clusterInterfaceObject);
                }
                $competenceInterfaceObject->addInterfaceObject($categoryInterfaceObject);
            }

        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $competenceInterfaceObject,
                                                                    TXT_UCF('COMPETENCES'),
                                                                    $displayWidth);
        if ($hasCategories) {
            $blockInterfaceObject->addActionLink(       EmployeeScoreInterfaceBuilderComponents::getEditBulkLink(   $employeeId,
                                                                                                                    $isAllowedEditCurrentScore));
            if ($showAnyRemarks) {
                $blockInterfaceObject->addActionLink(   EmployeeScoreInterfaceBuilderComponents::getToggleNotesVisibilityLink(self::COMPETENCE_NOTE_VIEW_HTML_ID));
            }
        }
        return $blockInterfaceObject->fetchHtml();
    }

    static function calculateEditWidths($displayWidth)
    {
        $scoreWidth         = CUSTOMER_OPTION_SHOW_SCORE_AS_NORM_TEXT ? self::COMPETENCE_SCORE_EDIT_WIDTH_TEXT : self::COMPETENCE_SCORE_EDIT_WIDTH_NUMERIC;
        $actionsWidth       = self::COMPETENCE_SCORE_EDIT_ACTIONS;
        $competenceWidth    = $displayWidth - ($scoreWidth + $actionsWidth);

        return array($competenceWidth, $scoreWidth, $actionsWidth);
    }


    // competence scores
    static function getEditBulkHtml($displayWidth,
                                    $employeeId,
                                    EmployeeCompetenceCategoryClusterScoreCollection $employeeCompetenceScoreCollection)
    {
        $contentHtml = '';
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_BULK_SCORE);

        $showRemarks    = CUSTOMER_OPTION_USE_SKILL_NOTES;
        $showNorm       = CUSTOMER_OPTION_SHOW_NORM;
        $showCategory   = CUSTOMER_OPTION_SHOW_KS;

        // scherm opbouwen
        $competenceValueObjects = array();

        $categoryIds = $employeeCompetenceScoreCollection->getCategoryIds();
        if (count($categoryIds) == 0) {
            $contentHtml = TXT_UCF('NO_COMPETENCE_RETURN');
        } else {

            // form opbouwen
            $competenceInterfaceObject = EmployeeCompetenceGroupEdit::create($displayWidth);
            $competenceInterfaceObject->setToggleNotesVisibilityLink(  EmployeeScoreInterfaceBuilderComponents::getToggleNotesVisibilityLink(self::COMPETENCE_NOTE_EDIT_HTML_ID));
            $competenceInterfaceObject->setToggleNotesHtmlId(          self::COMPETENCE_NOTE_EDIT_HTML_ID);
            $competenceInterfaceObject->setShowRemarks(                $showRemarks);

            foreach($categoryIds as $categoryId) {
                $categoryName = $employeeCompetenceScoreCollection->getCategoryName($categoryId);
                // interface object per category
                $categoryInterfaceObject = EmployeeCompetenceCategoryGroupEdit::create($displayWidth, $categoryName);
                $categoryInterfaceObject->setShowCategoryName($showCategory);

                // alle clusters in de category verwerkern
                $categoryClusterIds = $employeeCompetenceScoreCollection->getCategoryClusterIds($categoryId);
                foreach($categoryClusterIds as $clusterId) {
                    $clusterScoreCollection = $employeeCompetenceScoreCollection->getEmployeeClusterScoreCollection($categoryId,
                                                                                                                    $clusterId);
                    $clusterName      = $clusterScoreCollection->getClusterName($clusterId);
                    $scoreCollections = $clusterScoreCollection->getEmployeeScoreCollections();

                    // interface object per cluster
                    $clusterInterfaceObject = EmployeeCompetenceClusterGroupEdit::create(   $displayWidth,
                                                                                            $clusterName);
                    $clusterInterfaceObject->setShowClusterInfo(true);

                    list($competenceWidth, $scoreWidth, $actionsWidth) = self::calculateEditWidths($displayWidth);
                    $clusterInterfaceObject->setWidths($competenceWidth, $scoreWidth, $actionsWidth);

                    $clusterCompetenceValueObjects = self::fillClusterEditInterfaceObject(  $displayWidth,
                                                                                            $showRemarks,
                                                                                            $showNorm,
                                                                                            $scoreCollections,
                                                                                            $clusterInterfaceObject);

                    $competenceValueObjects = array_merge($competenceValueObjects, $clusterCompetenceValueObjects);
                    $categoryInterfaceObject->addInterfaceObject($clusterInterfaceObject);
                }
                $competenceInterfaceObject->addInterfaceObject($categoryInterfaceObject);
            }

            $contentHtml = $competenceInterfaceObject->fetchHtml();
        }

        // safeForm
        $safeFormHandler->storeSafeValue('employeeId',              $employeeId);
        $safeFormHandler->storeSafeValue('competenceValueObjects',  $competenceValueObjects);

        $safeFormHandler->addPrefixStringInputFormatType(       EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix(ScaleValue::SCALE_Y_N), true);
        $safeFormHandler->addPrefixStringInputFormatType(       EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix(ScaleValue::SCALE_1_5), true);
        if ($showRemarks) {
            $safeFormHandler->addPrefixStringInputFormatType(   EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix(ScaleValue::SCALE_Y_N), true);
            $safeFormHandler->addPrefixStringInputFormatType(   EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix(ScaleValue::SCALE_1_5), true);
        }
        $safeFormHandler->finalizeDataDefinition();

        return array($safeFormHandler, $contentHtml);
    }

    private function fillClusterEditInterfaceObject($displayWidth,
                                                    $showRemarks,
                                                    $showNorm,
                                                    $scoreCollections,
                                                    &$clusterInterfaceObject)
    {
        $clusterCompetenceValueObjects = array();

        $isFirst = true;
        foreach($scoreCollections as $scoreCollection) {
            $employeeCompetenceValueObject      = $scoreCollection->getCompetenceValueObject();
            $competenceId                       = $employeeCompetenceValueObject->getCompetenceId();
            $competenceScaleType                = $employeeCompetenceValueObject->getCompetenceScaleType();
            $clusterCompetenceValueObjects[]    = $employeeCompetenceValueObject;

            if ($isFirst) {
                $isFirst = false;
                $clusterHasMainCompetence = $employeeCompetenceValueObject->getCompetenceIsMain() == COMPETENCE_CLUSTER_IS_MAIN;
                $clusterInterfaceObject->setClusterHasMainCompetence($clusterHasMainCompetence);
            }

            $scoreValueObject = $scoreCollection->getScoreValueObject();

            $scoreInputName = EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix(  $competenceScaleType) . $competenceId;
            $noteInputName  = EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix(   $competenceScaleType) . $competenceId;

            // score interface vullen
            $interfaceObject = EmployeeCompetenceScoreEdit::createWithValueObjects( $scoreValueObject,
                                                                                    $employeeCompetenceValueObject,
                                                                                    $displayWidth);

            list($competenceWidth, $scoreWidth, $actionsWidth) = self::calculateEditWidths($displayWidth);
            $interfaceObject->setWidths($competenceWidth, $scoreWidth, $actionsWidth);

            $interfaceObject->setShowRemarks(               $showRemarks);
            $interfaceObject->setShowNorm(                  $showNorm);
            $interfaceObject->setHasClusterMainCompetence(  $clusterHasMainCompetence);
            $interfaceObject->setIsEmptyAllowed(            $employeeCompetenceValueObject->competenceIsOptional);

            $interfaceObject->setScoreInputName(            $scoreInputName);
            if ($showRemarks) {
                $interfaceObject->setNoteInputName(         $noteInputName);
            }
            $interfaceObject->setKeepAliveCallback(         EmployeeScoreInterfaceBuilderComponents::getKeepAliveCallback());

            // competence interface stuff verder vullen...
            $interfaceObject->setSymbolIsKeyCompetence(         $employeeCompetenceValueObject->competenceIsKey ? SIGN_IS_KEY_COMP : SIGN_IS_NOT_KEY_COMP);
            $interfaceObject->setSymbolIsAdditionalCompetence(  $employeeCompetenceValueObject->competenceFunctionIsMain ? '' : SIGN_COMP_ADDITIONAL_PROFILE);
            $interfaceObject->setDetailLinkId(                  CompetenceInterfaceBuilderComponents::getDetailLinkId(                      $competenceId));
            $interfaceObject->setDetailOnClick(                 CompetenceInterfaceBuilderComponents::getShowDetailOnClick(                 $competenceId,
                                                                                                                                            CompetenceInterfaceBuilder::DISPLAY_MODE_POPUP));
            $interfaceObject->setToggleNoteVisibilityLink(      EmployeeScoreInterfaceBuilderComponents::getToggleEditNoteVisibilityLink(   self::COMPETENCE_NOTE_EDIT_HTML_ID,
                                                                                                                                            self::COMPETENCE_NOTE_EDIT_PREFIX,
                                                                                                                                            $competenceId));
            $interfaceObject->setToggleNotePrefixId(            self::COMPETENCE_NOTE_EDIT_PREFIX);
            $interfaceObject->setIsInitialVisibleNotes(         self::COMPETENCE_NOTE_EDIT_INITIAL_VISIBLE);


            $clusterInterfaceObject->addInterfaceObject($interfaceObject);
        }
        return $clusterCompetenceValueObjects;
    }

    static function getEditClusterHtml( $displayWidth,
                                        $employeeId,
                                        EmployeeCompetenceClusterScoreCollection $clusterScoreCollection)
    {
        $contentHtml = '';
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_CLUSTER_SCORE);

        $showRemarks    = CUSTOMER_OPTION_USE_SKILL_NOTES;
        $showNorm       = CUSTOMER_OPTION_SHOW_NORM;

        $clusterId          = $clusterScoreCollection->getClusterId();
        $clusterName        = $clusterScoreCollection->getClusterName();
        $scoreCollections   = $clusterScoreCollection->getEmployeeCompetenceScoreCollections();


        if (count($scoreCollections) == 0) {
            $contentHtml = TXT_UCF('NO_COMPETENCE_RETURN');
        } else {

            $groupInterfaceObject = EmployeeCompetenceScoreGroupEdit::create(   $displayWidth,
                                                                                $clusterName);

            list($competenceWidth, $scoreWidth, $actionsWidth) = self::calculateEditWidths($displayWidth);
            $groupInterfaceObject->setWidths($competenceWidth, $scoreWidth, $actionsWidth);


            $groupInterfaceObject->setShowRemarks(                  $showRemarks);
            $groupInterfaceObject->setToggleNotesVisibilityLink(    EmployeeScoreInterfaceBuilderComponents::getToggleNotesVisibilityLink(self::COMPETENCE_NOTE_EDIT_HTML_ID));
            $groupInterfaceObject->setToggleNotesHtmlId(            self::COMPETENCE_NOTE_EDIT_HTML_ID);

            $clusterCompetenceValueObjects = self::fillClusterEditInterfaceObject(  $displayWidth,
                                                                                    $showRemarks,
                                                                                    $showNorm,
                                                                                    $scoreCollections,
                                                                                    $groupInterfaceObject);

            $contentHtml = $groupInterfaceObject->fetchHtml();
        }

        // safeForm
        $safeFormHandler->storeSafeValue('employeeId',              $employeeId);
        $safeFormHandler->storeSafeValue('clusterId',               $clusterId);
        $safeFormHandler->storeSafeValue('competenceValueObjects',  $clusterCompetenceValueObjects);

        $safeFormHandler->addPrefixStringInputFormatType(       EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix(ScaleValue::SCALE_Y_N), true);
        $safeFormHandler->addPrefixStringInputFormatType(       EmployeeScoreInterfaceBuilderComponents::getEditScorePrefix(ScaleValue::SCALE_1_5), true);
        if ($showRemarks) {
            $safeFormHandler->addPrefixStringInputFormatType(   EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix(ScaleValue::SCALE_Y_N), true);
            $safeFormHandler->addPrefixStringInputFormatType(   EmployeeScoreInterfaceBuilderComponents::getEditNotePrefix(ScaleValue::SCALE_1_5), true);
        }
        $safeFormHandler->finalizeDataDefinition();

        return array(   $safeFormHandler,
                        $contentHtml,
                        $clusterName);
    }

    /// HISTORY SCORES
    static function getHistoryHtml( $displayWidth,
                                    $employeeId,
                                    $competenceValueObject)
    {
        $interfaceObject = EmployeeCompetenceScoreHistory::create($displayWidth);
        $interfaceObject->setShowRemarks(   CUSTOMER_OPTION_USE_SKILL_NOTES);

        // ophalen scores
        $valueObjects = EmployeeScoreService::getValueObjects(  $employeeId,
                                                                $competenceValueObject->getId());
        foreach ($valueObjects as $valueObject) {
            // haal de assessment cycle bij deze score op
            $historyPeriod = AssessmentCycleService::getCurrentValueObject($valueObject->savedDatetime);
            $valueObject->setAssessmentCycleValueObject($historyPeriod);
            $interfaceObject->addValueObject($valueObject);
        }

        return $interfaceObject->fetchHtml();
    }

}

?>
