<?php

/**
 * Description of EmployeePdpActionInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/AbstractEmployeeInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/pdpAction/EmployeePdpActionInterfaceBuilderComponents.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');
require_once('modules/interface/converter/library/competence/CategoryConverter.class.php');

require_once('modules/model/service/library/PdpActionService.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionLibrarySelector.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionSelectGroup.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionSelectClusterGroup.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionSelectClusterView.class.php');

require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionCompetenceSelector.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionCompetenceSelectGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionCompetenceSelectCategoryGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionCompetenceSelectClusterGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionCompetenceSelectView.class.php');

require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionGroup.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionView.class.php');
require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionDelete.class.php');

require_once('modules/interface/interfaceobjects/employee/pdpAction/EmployeePdpActionUserDefinedEdit.class.php');

require_once('modules/interface/converter/employee/pdpAction/PdpActionNameConverter.class.php');
require_once('modules/interface/converter/employee/pdpAction/PdpActionCompletedConverter.class.php');

require_once('modules/model/service/employee/pdpAction/EmployeePdpActionService.class.php');

class EmployeePdpActionInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{

    const EDIT_HTML_PDP_LIBRARY_TOGGLE_HTML_ID      = 'pdp-edit-library-toggler';
    const EDIT_HTML_PDP_LIBRARY_CONTENT_HTML_ID     = 'pdp-edit-content';
    const EDIT_HTML_COMPETENCES_TOGGLE_HTML_ID      = 'pdp-edit-competences-toggler';
    const EDIT_HTML_COMPETENCES_CONTENT_HTML_ID     = 'pdp-edit-competences-content';
    const EDIT_COMPETENCES_CHECKBOX_INPUT_PREFIX_ID = 'kspid_';
    const TOTAL_COST_WIDTH                          = 300;
    const EMPLOYEE_PDP_ACTION_LABEL_WIDTH           = 100;

    static function getActionsHtml( $displayWidth,
                                    $employeeId)
    {
        $blockInterfaceObject = BaseTitleInterfaceObject::create(   TXT_UCF('PDP_ACTIONS'),
                                                                    $displayWidth);
        $blockInterfaceObject->setIsSubHeader();
        $blockInterfaceObject->addActionLink(   EmployeePdpActionInterfaceBuilderComponents::getAddLink($employeeId));

        return $blockInterfaceObject->fetchHtml();
    }


    static function getViewHtml($displayWidth,
                                $employeeId)
    {
        $contentHtml = '';

        $valueObjects = EmployeePdpActionService::getValueObjects($employeeId);

        $assessmentCycleKeys = array_keys($valueObjects);

        foreach($assessmentCycleKeys as $assessmentCycleKey) {
            $firstValueObject = reset($valueObjects[$assessmentCycleKey]); // geeft eerste element
            $assessmentCycleValueObject = $firstValueObject->getAssessmentCycleValueObject();
            $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getDetailInfo(   $displayWidth,
                                                                                     $assessmentCycleValueObject);

            $groupInterfaceObject = EmployeePdpActionGroup::create($displayWidth);

            $totalCost = 0.0;
            foreach($valueObjects[$assessmentCycleKey] as $valueObject) {
                $employeePdpActionId = $valueObject->getId();
                if (!empty($employeePdpActionId)) {
                    if (!$valueObject->isCancelled()) {
                        $totalCost += $valueObject->getCost();
                    }

                    $interfaceObject = EmployeePdpActionView::createWithValueObject($valueObject, $displayWidth);
                    $interfaceObject->addActionLink( EmployeePdpActionInterfaceBuilderComponents::getEditLink(  $employeeId,
                                                                                                                $employeePdpActionId));
                    $interfaceObject->addActionLink( EmployeePdpActionInterfaceBuilderComponents::getRemoveLink($employeeId,
                                                                                                                $employeePdpActionId));

                    $relatedCompetences = EmployeePdpActionCompetenceService::getRelatedCompetenceNames($employeeId,
                                                                                                        $employeePdpActionId);

                    $showDetailInfo = ($valueObject->hasNote() || !empty($relatedCompetences));
                    $interfaceObject->setShowDetailInfo(    $showDetailInfo);
                    $interfaceObject->setRelatedCompetences($relatedCompetences);
                    $interfaceObject->setDateWarning(       $valueObject->isNotCompleted() &&
                                                            DateUtils::isBefore(REFERENCE_DATE, $valueObject->getTodoBeforeDate()));

                    $groupInterfaceObject->addInterfaceObject($interfaceObject);
                }
            }
            $groupInterfaceObject->setTotalCost($totalCost);

            $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                        $assessmentCycleInfo->fetchHtml(),
                                                                        $displayWidth);
            $blockInterfaceObject->setActionsWidth(self::TOTAL_COST_WIDTH);
            $totalCostHtml = '<p style="padding-top:5px;">' . TXT_UCF('TOTAL_COSTS') . ': &euro; ' . PdpCostConverter::display($totalCost) . '</p>';
            $blockInterfaceObject->addActionLink($totalCostHtml);

            $contentHtml .= $blockInterfaceObject->fetchHtml();
        }
        return $contentHtml;
    }

    static function getAddHtml( $displayWidth,
                                $employeeId)
    {

        return self::generatePdpActionFormHtml( $displayWidth,
                                                $employeeId,
                                                NULL,
                                                FORM_MODE_NEW);
    }

    static function getEditHtml(    $displayWidth,
                                    $employeeId,
                                    $employeePdpActionId)
    {

        return self::generatePdpActionFormHtml( $displayWidth,
                                                $employeeId,
                                                $employeePdpActionId,
                                                FORM_MODE_EDIT);
    }

    static function getEditUserDefinedHtml( $displayWidth,
                                            EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__EDIT_PDP_ACTION_USER_DEFINED);

        $safeFormHandler->storeSafeValue('employeeId',          $valueObject->getEmployeeId());
        $safeFormHandler->storeSafeValue('employeePdpActionId', $valueObject->getEmployeePdpActionId());
        $safeFormHandler->storeSafeValue('prevPdpActionId',     $valueObject->getId());

        $safeFormHandler->addIntegerInputFormatType('ID_PDPAID');
        $safeFormHandler->addStringInputFormatType('fill_action');
        $safeFormHandler->addStringInputFormatType('fill_provider');
        $safeFormHandler->addStringInputFormatType('fill_duration');
        $safeFormHandler->addStringInputFormatType('fill_cost');

        $safeFormHandler->finalizeDataDefinition();


        $pdpActionLibraryId = $valueObject->getId();
        $pdpActionLibrarySelector = self::getPdpActionLibrarySelector(  EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_WIDTH,
                                                                        self::EMPLOYEE_PDP_ACTION_LABEL_WIDTH,
                                                                        EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_HEIGHT,
                                                                        $pdpActionLibraryId);

        $interfaceObject = EmployeePdpActionUserDefinedEdit::createWithValueObject( $valueObject,
                                                                                    $displayWidth);


        $interfaceObject->setPdpActionLibrarySelector( $pdpActionLibrarySelector);

        $interfaceObject->setDateWarning(       $valueObject->isNotCompleted() &&
                                                DateUtils::isBefore(REFERENCE_DATE, $valueObject->getTodoBeforeDate()));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);

    }

    static function getRemoveHtml(  $displayWidth,
                                    $employeeId,
                                    $employeePdpActionId)
    {

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEE__DELETE_PDP_ACTION);

        $safeFormHandler->storeSafeValue('employeeId',          $employeeId);
        $safeFormHandler->storeSafeValue('employeePdpActionId', $employeePdpActionId);
        $safeFormHandler->finalizeDataDefinition();

        $valueObject = EmployeePdpActionService::getValueObject($employeeId,
                                                                $employeePdpActionId);

        $interfaceObject = EmployeePdpActionDelete::createWithValueObject(  $valueObject,
                                                                            $displayWidth);

        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_EMPLOYEE_PDP_ACTION'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    private static function generatePdpActionFormHtml(  $displayWidth,
                                                        $employeeId,
                                                        $employeePdpActionId,
                                                        $formMode)
    {
        $contentHtml = '';

        if ($formMode == FORM_MODE_NEW) {
            $formIdentifier = SAFEFORM_EMPLOYEE__ADD_PDP_ACTION;
        } elseif ($formMode == FORM_MODE_EDIT) {
            $formIdentifier = SAFEFORM_EMPLOYEE__EDIT_PDP_ACTION;
        }

        $safeFormHandler = SafeFormHandler::create($formIdentifier);


        if (!empty($employeePdpActionId)) {
            $sql = 'SELECT
                        epa.*
                    FROM
                        employees_pdp_actions epa
                    WHERE
                        epa.customer_id  = ' . CUSTOMER_ID . '
                        AND epa.ID_E     = ' . $employeeId . '
                        AND epa.ID_PDPEA = ' . $employeePdpActionId;
            $pdpeaQuery = BaseQueries::performQuery($sql);
            $pdpea = @mysql_fetch_assoc($pdpeaQuery);
            $pdpActionLibraryId = $pdpea['ID_PDPAID'];
            $isUserDefined = $pdpea['is_user_defined'];
        } else {
            $pdpActionLibraryId = NULL;
            $isUserDefined = FALSE;
        }

        $safeFormHandler->storeSafeValue('ID_E', $employeeId);
        if ($formMode == FORM_MODE_EDIT) {
            $safeFormHandler->storeSafeValue('ID_PDPEA', $employeePdpActionId);
            $safeFormHandler->storeSafeValue('prev_ID_PDPAID', $pdpActionLibraryId);
        }

        $safeFormHandler->addIntegerInputFormatType('ID_PDPAID', true);
        $safeFormHandler->addPrefixStringInputFormatType('kspid_');
        $safeFormHandler->addIntegerInputFormatType('user_id');
        $safeFormHandler->addStringInputFormatType('end_date');
        $safeFormHandler->addStringInputFormatType('is_completed');
        $safeFormHandler->addStringInputFormatType('start_date');

        $safeFormHandler->addStringInputFormatType('notes');
        //if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
            //$safeFormHandler->addIntegerInputFormatType('fill_cluster');
            $safeFormHandler->addStringInputFormatType('fill_action');
            $safeFormHandler->addStringInputFormatType('fill_provider');
            $safeFormHandler->addStringInputFormatType('fill_duration');
            $safeFormHandler->addStringInputFormatType('fill_cost');
        //}
        if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
            $safeFormHandler->addIntegerInputFormatType('action_owner');
        } else {
            $safeFormHandler->addIntegerArrayInputFormatType('ID_PD');
        }

//        $relatedCompetenceIds = EmployeePdpActionCompetenceService::getRelatedCompetenceIds($employeeId,
//                                                                                            $employeePdpActionId);


//        $relatedCompetences = EmployeePdpActionCompetenceService::getRelatedCompetenceNames($employeeId,
//                                                                                            $employeePdpActionId);

//        $relatedCompetenceLabel = empty($relatedCompetences) ? TXT_UCF(NO_RELATED_COMPETENCES) : $relatedCompetences;

        list($competenceSelector, $competenceIds) = self::getPdpActionCompetenceSelector(   EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_WIDTH,
                                                                                            EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_HEIGHT,
                                                                                            $employeeId,
                                                                                            $employeePdpActionId);
        $safeFormHandler->storeSafeValue('IDs_AVAIL_SKILLS', $competenceIds);

        $safeFormHandler->finalizeDataDefinition();


        $pdpActionLibrarySelector = self::getPdpActionLibrarySelector(  EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_WIDTH,
                                                                        self::EMPLOYEE_PDP_ACTION_LABEL_WIDTH,
                                                                        EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_HEIGHT,
                                                                        $pdpActionLibraryId);

//        $selectablePdpActionLibraryId = $isUserDefined ? $pdpActionLibraryId : NULL;
        //$selectablePdpActionClusterId = $isUserDefined ? $pdpActionClusterId : NULL;


        $contentHtml .= '
        <table border="0" cellspacing="2" cellpadding="4" style="width:' . $displayWidth . 'px;" >
            <tr >
                <td>
                    ' . $pdpActionLibrarySelector->fetchHtml() . '
                </td>
            </tr>';

        $contentHtml .= '
            <tr>
                <td>
                    <table width="100%">';
        $contentHtml .= '
                        <tr>
                            <td class="form-label" style="width:100px;">
                                ' . TXT_UCF('PDP_ACTION') . ' ' . REQUIRED_FIELD_INDICATOR . '
                            </td>
                            <td class="form-value">';
                            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                                $contentHtml .= '
                                <input type="text" size="60" id="fill_action" name="fill_action" value="' . $pdpea['action'] . '"/>';
                            } else {
                                $contentHtml .= '
                                <span id="show_action">' . $pdpea['action'] . '</span>
                                <input type="hidden" id="fill_action" name="fill_action" value="' . $pdpea['action'] . '"/>';
                            }
        $contentHtml .= '
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                ' . TXT_UCF('PROVIDER') . ' ' . REQUIRED_FIELD_INDICATOR . '
                            </td>
                            <td class="form-value">';
                            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                                $contentHtml .= '
                                <input type="text" size="60" id="fill_provider" name="fill_provider" value="' . $pdpea['provider'] . '"/>';
                            } else {
                                $contentHtml .= '
                                <span id="show_provider">' . $pdpea['provider'] . '</span>
                                <input type="hidden" id="fill_provider" name="fill_provider" value="' . $pdpea['provider'] . '"/>';
                            }
        $contentHtml .= '
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                ' . TXT_UCF('DURATION') . ' ' . REQUIRED_FIELD_INDICATOR . '
                            </td>
                            <td class="form-value">';
                            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                                $contentHtml .= '
                                <input type="text" size="30" id="fill_duration" name="fill_duration" value="' . $pdpea['duration'] . '"/>';
                            } else {
                                $contentHtml .= '
                                <span id="show_duration">' . $pdpea['duration'] . '</span>
                                <input type="hidden" id="fill_duration" name="fill_duration" value="' . $pdpea['duration'] . '"/>';
                            }
        $contentHtml .= '
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                ' . TXT_UCF('COST') . ' ' . REQUIRED_FIELD_INDICATOR . '
                            </td>
                            <td class="form-value">';
                            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                                $contentHtml .= '
                                &euro;&nbsp;<input type="text" size="20" id="fill_cost" name="fill_cost" value="' . PdpCostConverter::input($pdpea['costs']) . '"/>';
                            } else {
                                $contentHtml .= '
                                &euro;&nbsp;<span id="show_cost" style="margin:0px;">' . PdpCostConverter::display($pdpea['costs']) . '</span>
                                <input type="hidden" id="fill_cost" name="fill_cost" value="' . PdpCostConverter::input($pdpea['costs']) . '"/>';
                            }
        $contentHtml .= '
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        ';
        // hbd: tussenvoegen checkbox competenties
        $contentHtml .='
            <tr>
                <td>
                    <hr/>
                    ' . $competenceSelector->fetchHtml() . '
                </td>
            </tr>';
        // hbd:end  tussenvoegen checkbox competenties

        $contentHtml .='
            <tr>
                <td>
                    <hr/>
                    <table>
                        <tr>';
//                        if (empty($employeePdpActionId)) {
//                            $contentHtml .= '
//                            <td width="130">
//                                &nbsp;
//                            </td>
//                            <td>
//                                &nbsp;
//                            </td>';
//                        } else {
                            $checked_n = empty($pdpea['is_completed']) || $pdpea['is_completed'] == PdpActionCompletedStatusValue::NOT_COMPLETED ? 'checked' : '';
                            $checked_y = $pdpea['is_completed'] == PdpActionCompletedStatusValue::COMPLETED ? 'checked' : '';
                            $checked_c = $pdpea['is_completed'] == PdpActionCompletedStatusValue::CANCELLED ? 'checked' : '';
                            $contentHtml .='
                            <td  class="form-label" width="130">
                                ' . TXT_UCW('COMPLETED') . ' ' . REQUIRED_FIELD_INDICATOR . '
                            </td>
                            <td  class="form-value">
                                <input name="is_completed" type="radio" value="' . PdpActionCompletedStatusValue::NOT_COMPLETED . '" ' . $checked_n . '> ' .
                                    PdpActionCompletedConverter::input(PdpActionCompletedStatusValue::NOT_COMPLETED) . ' &nbsp;
                                <input name="is_completed" type="radio" value="' . PdpActionCompletedStatusValue::COMPLETED . '" ' . $checked_y . '> ' .
                                    PdpActionCompletedConverter::input(PdpActionCompletedStatusValue::COMPLETED) . ' &nbsp;
                                <input name="is_completed" type="radio" value="' . PdpActionCompletedStatusValue::CANCELLED . '" ' . $checked_c . '> ' .
                                    PdpActionCompletedConverter::input(PdpActionCompletedStatusValue::CANCELLED) . '
                            </td>';
//                        }
                        $contentHtml .='
                        </tr>
                        <tr>
                            <td colspan="100%">
                                <table cellpadding="4">';
                                    $contentHtml .='
                                    <tr>
                                        <td class="form-label" style="width:130px;">
                                            ' . TXT_UCF('ACTION_OWNER') . ' ' . REQUIRED_FIELD_INDICATOR . '
                                        </td>';
                                if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
                                    $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);
                                    $bossId             = $employeeInfoValueObject->getBossId();
                                    $actionOwner        = $pdpea['action_owner'];
                                    $checkedEmployee    = $actionOwner == $employeeId ? ' checked="checked"' : '';
                                    $checkedManager     = empty($checkedEmployee) || $actionOwner == $bossId ? ' checked="checked"' : '';
                                    $contentHtml .='
                                        <td class="form-value" colspan="3">';
                                    if (!empty($bossId)) {
                                        $contentHtml .='
                                            <input name="action_owner" type="radio" value="' . $bossId . '" ' . $checkedManager . '>&nbsp;' . $employeeInfoValueObject->getBossName() . '&nbsp;&nbsp;<em>' . TXT_UCF('MANAGER') . '</em><br/>';
                                    } else {
                                        $checkedEmployee = ' checked="checked"';
                                    }
                                    $contentHtml .='
                                            <input name="action_owner" type="radio" value="' . $employeeId . '" ' . $checkedEmployee . '>&nbsp;' . $employeeInfoValueObject->getEmployeeName() . '&nbsp;&nbsp;<em>' . TXT_UCF('EMPLOYEE') . '</em>
                                        </td>';

                                } else {
                                    $contentHtml .='
                                        <td class="form-value" colspan="3">';
                                            $sql = 'SELECT
                                                        *
                                                    FROM
                                                        users
                                                    WHERE
                                                        customer_id = ' . CUSTOMER_ID . '
                                                        AND is_inactive = ' . USER_IS_ACTIVE . '
                                                    ORDER BY
                                                        name';
                                            $get_pdpto = BaseQueries::performQuery($sql);
                                            if (@mysql_num_rows($get_pdpto) == 0) {
                                                $contentHtml .= TXT_UCW('NO_PDP_ACTION_OWNER_RETURN');
                                            } else {
                                            $contentHtml .='
                                                <select name="user_id">
                                                    <option value=""> - '. TXT_LC('SELECT').' - </option>';
                                                    while ($get_pdpto_row = @mysql_fetch_assoc($get_pdpto)) {
                                                        $selected_to = $get_pdpto_row[user_id] == $pdpea[ID_PDPTOID] ? 'selected' : '';
                                                        $contentHtml .='
                                                        <option value="' . $get_pdpto_row[user_id] . '" ' . $selected_to . '>' . $get_pdpto_row[name] . '</option>';
                                                    }
                                            $contentHtml .='
                                                </select>';
                                            }
                                            $contentHtml .='
                                        </td>
                                    </tr>';
                                }
                                if (empty($employeePdpActionId)) { // nieuwe actie
                                    $deadline_date = DEFAULT_DATE;
                                    $strStartDate = DateUtils::calculateRelativeDisplayDate($deadline_date, DEFAULT_ALERTDATE_OFFSET);
                                } else {
                                    $deadline_date = $pdpea['end_date'];
                                    $strStartDate = $pdpea['start_date'];
                                }
                                $calendarInputDeadlineDate = DateUtils::convertToDatabaseDate($deadline_date);
                                $calendarInputDeadlineOnChangeFunction = 'showDateRelative(\'end_date\', ' . JS_DEFAULT_DATE_FORMAT . ', \'start_date\', ' . JS_RELATIVE_DAYS_DEADLINE . ');';
                                $calendarInputNotificationDate = DateUtils::convertToDatabaseDate($strStartDate);

                                $contentHtml .= '
                                    <tr>
                                        <td class="form-label" width="130">
                                            ' . TXT_UCF('DEADLINE_DATE') . ' ' . REQUIRED_FIELD_INDICATOR . '
                                        </td>
                                        <td  class="form-value" width="200">
                                            ' . InterfaceBuilderComponents::getCalendarInputPopupHtml(  'end_date',
                                                                                                        $calendarInputDeadlineDate,
                                                                                                        InterfaceBuilderComponents::CALENDAR_INPUT_NO_CLASS,
                                                                                                        InterfaceBuilderComponents::CALENDAR_INPUT_READONLY,
                                                                                                        $calendarInputDeadlineOnChangeFunction) . '
                                        </td>
                                        <td  class="form-label" width="130">
                                            ' . TXT_UCF('NOTIFICATION_DATE') . '
                                        </td>
                                        <td  class="form-value">
                                            ' . InterfaceBuilderComponents::getCalendarInputPopupHtml(  'start_date',
                                                                                                        $calendarInputNotificationDate) . '

                                            <a href="" onclick="xajax_moduleEmployees_clearNotificationDate_deprecated();return false;"><img src="' . ICON_ERASE . '" class="icon-style" border="0" title="Clear notification date"></a>
                                        </td>
                                    </tr>';
                                if (!CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
                                    $contentHtml .= '
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td colspan="2">
                                            <div id="ne">' . getEmailsForNotificationHtml(1, $employeePdpActionId) . '</div>
                                        </td>
                                    </tr>';
                                }
                                $contentHtml .= '
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="form-label" colspan="100%">
                    ' . TXT_UCF('REASONS_REMARKS') . '
            </tr>
            <tr>
                <td class="form-value" colspan="100%">
                    <textarea name="notes" style="width:700px;height:100px;">' . $pdpea[notes] . '</textarea>
                </td>
            </tr>
        </table>';
//        </form>';

        return array($safeFormHandler, $contentHtml);
    }

    static function getPdpActionLibrarySelector(    $displayWidth,
                                                    $labelWidth,
                                                    $contentHeight,
                                                    $employeePdpActionId)
    {
        $selectorInterfaceObject = EmployeePdpActionLibrarySelector::create($labelWidth,
                                                                            self::EDIT_HTML_PDP_LIBRARY_TOGGLE_HTML_ID,
                                                                            self::EDIT_HTML_PDP_LIBRARY_CONTENT_HTML_ID);

        $interfaceObject = self::getPdpActionLibrarySelectGroup($displayWidth,
                                                                $contentHeight,
                                                                $employeePdpActionId);
        $selectorInterfaceObject->setInterfaceObject($interfaceObject);


        $toggleActionLink = EmployeePdpActionInterfaceBuilderComponents::getTogglePdpActionLibraryLink(EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW);
        $selectorInterfaceObject->addActionLink($toggleActionLink);

        return $selectorInterfaceObject;
    }

    static function getPdpActionLibrarySelectGroup( $displayWidth,
                                                    $contentHeight,
                                                    $employeePdpActionId = NULL)
    {
        $pdpActions = PdpActionService::getValueObjects();

        $selectInterfaceObject = PdpActionSelectGroup::create(  $displayWidth,
                                                                $contentHeight);

        $clusterNames = array_keys($pdpActions);

        foreach($clusterNames as $clusterName ) {
            $groupInterfaceObject = PdpActionSelectClusterGroup::create($displayWidth,
                                                                        $clusterName);

            $clusterPdpActions = $pdpActions[$clusterName];
            foreach($clusterPdpActions as $valueObject) {
                $interfaceObject = PdpActionSelectClusterView::createWithValueObject(   $valueObject,
                                                                                        $displayWidth);
                $interfaceObject->setIsSelected($valueObject->getId() == $employeePdpActionId);
                $interfaceObject->setSelectLink( EmployeePdpActionInterfaceBuilderComponents::getPdpActionSelectLink($valueObject->getId()));
                $groupInterfaceObject->addInterfaceObject($interfaceObject);
            }

            $selectInterfaceObject->addInterfaceObject($groupInterfaceObject);
        }

        return $selectInterfaceObject;
    }

    private static function getPdpActionCompetenceSelector( $displayWidth,
                                                            $contentHeight,
                                                            $employeeId,
                                                            $employeePdpActionId)
    {

        $selectorInterfaceObject = EmployeePdpActionCompetenceSelector::create( $displayWidth,
                                                                                self::EDIT_HTML_COMPETENCES_TOGGLE_HTML_ID,
                                                                                self::EDIT_HTML_COMPETENCES_CONTENT_HTML_ID);

        list($interfaceObject, $competenceIds) = self::getPdpActionSelectCompetences(   $displayWidth,
                                                                                        $contentHeight,
                                                                                        $employeeId,
                                                                                        $employeePdpActionId);
        $selectorInterfaceObject->setInterfaceObject($interfaceObject);

        $relatedCompetences = EmployeePdpActionCompetenceService::getRelatedCompetenceNames($employeeId,
                                                                                            $employeePdpActionId);

        $relatedCompetenceLabel = empty($relatedCompetences) ? TXT_UCF(NO_RELATED_COMPETENCES) : $relatedCompetences;
        $selectorInterfaceObject->setRelatedCompetenceLabel($relatedCompetenceLabel);


        $competencesToggleLink  = EmployeePdpActionInterfaceBuilderComponents::getToggleCompetencesLink(EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW);
        $selectorInterfaceObject->addActionLink($competencesToggleLink);

        return array($selectorInterfaceObject, $competenceIds);
    }

    static function getPdpActionSelectCompetences(  $displayWidth,
                                                    $contentHeight,
                                                    $employeeId,
                                                    $employeePdpActionId = NULL)
    {
        $competenceIds = array();
        // alle competenties ophalen
        $employeeCompetences    = EmployeePdpActionCompetenceService::getCompetenceValueObjects($employeeId);
        // welke zijn al aangevinkt
        $selectedCompetenceIds  = EmployeePdpActionCompetenceService::getRelatedCompetenceIds(  $employeeId,
                                                                                                $employeePdpActionId);

        // interface opbouwen
        $groupInterfaceObject = EmployeePdpActionCompetenceSelectGroup::create( $displayWidth,
                                                                                $contentHeight);
        $categoryIds = array_keys($employeeCompetences);
        foreach($categoryIds as $categoryId) {
            $categoryInterfaceObject = NULL;

            $clusterIds = array_keys($employeeCompetences[$categoryId]);
            foreach( $clusterIds as $clusterId) {
                $clusterInterfaceObject = NULL;

                $competences = $employeeCompetences[$categoryId][$clusterId];

                foreach($competences as $valueObject) {
                    $clusterName    = $valueObject->getClusterName();
                    $categoryName   = $valueObject->getCategoryName();
                    $competenceId   = $valueObject->getCompetenceId();

                    $interfaceObject = EmployeePdpActionCompetenceSelectView::createWithValueObject($valueObject,
                                                                                                    $displayWidth);

                    $isSelected = in_array($competenceId, $selectedCompetenceIds);
                    $interfaceObject->setIsSelected(    $isSelected);
                    $interfaceObject->setCheckboxPrefix(self::EDIT_COMPETENCES_CHECKBOX_INPUT_PREFIX_ID);

                    if (is_null($clusterInterfaceObject)) {
                        $clusterInterfaceObject = EmployeePdpActionCompetenceSelectClusterGroup::create($displayWidth,
                                                                                                        $clusterName);
                    }
                    $competenceIds[] = $competenceId;
                    $clusterInterfaceObject->addInterfaceObject($interfaceObject);
                }

                if (is_null($categoryInterfaceObject)) {
                    $categoryInterfaceObject = EmployeePdpActionCompetenceSelectCategoryGroup::create(  $displayWidth,
                                                                                                        $categoryName);
                    $categoryInterfaceObject->setShowCategory(  CUSTOMER_OPTION_SHOW_KS);
                }
                $categoryInterfaceObject->addInterfaceObject($clusterInterfaceObject);
            }
            $groupInterfaceObject->addInterfaceObject($categoryInterfaceObject);
        }

        return array($groupInterfaceObject, $competenceIds);
    }

}
?>
