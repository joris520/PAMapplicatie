<?php

require_once('modules/interface/interfaceobjects/base/BaseBlockHtmlInterfaceObject.class.php');

function moduleOptions_scales() {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_SCALE_DESCRIPTION)) {

        ApplicationNavigationService::setCurrentApplicationModule(MODULE_SCALES);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_OPTIONS__EDIT_SCALEVALUES);
        $safeFormHandler->addPrefixStringInputFormatType('desc');
        if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
            $safeFormHandler->addPrefixIntegerInputFormatType('spread');
        }

        if (CUSTOMER_OPTION_USE_FINAL_RESULT) {
            $safeFormHandler->addPrefixStringInputFormatType('desc_final');
        }

        $safeFormHandler->finalizeDataDefinition();

        $scalesTitle    = TXT_UCF('NORM');
        $scalesHtml     = '
                            <table class="content-table" style="width:900px;">
                                <tr>
                                    <td width="44"  class="bottom_line"><strong>' . TXT_UCF('NORM') . ':</strong> </td>
                                    <td width="82"  class="bottom_line"><strong>' . TXT_UCF('DEFAULT') . ': </strong></td>
                                    <td width="73"  class="bottom_line">&nbsp;</td>
                                    <td width="150" class="bottom_line"><strong>' . TXT_UCF('SCALE_VALUE_DESCRIPTION') . ': </strong></td>
                                    <td width="87"  class="bottom_line"><strong>' . (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? TXT_UCF('SCALE_SPREAD') . ': ' : '&nbsp;')  . '</strong></td>
                                    <td width="150" class="bottom_line"><strong>' . (CUSTOMER_OPTION_USE_FINAL_RESULT ? TXT_UCF('SCALE_TOTAL_SCORE_DESCRIPTION') . ': ' : '&nbsp;')  . '</strong></td>
                                </tr>';

        $sql = 'SELECT
                    *
                FROM
                    scale
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    scale_id';
        $queryResult =  BaseQueries::performQuery($sql);

        $i = 1;
        $lastNumericScore = 5;
        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            if (PermissionsService::isEditAllowed(PERMISSION_SCALE_DESCRIPTION)) {
                $set_default = '<a href="javascript:void(0)" onclick="document.getElementById(\'desc' . $i . '\').value = \'' . TXT_UCF(strtoupper($queryResult_row['default_desc'])) . '\'">' . TXT_UCF('DEFAULT') . ' &raquo;</a>';
            } else {
                $set_default = '&nbsp;';
            }

            switch ($queryResult_row['default_desc']) {
                case 'None':
                    $strDefaultDesc = TXT_UCF('NONE');
                    break;
                case 'Basic':
                    $strDefaultDesc = TXT_UCF('BASIC');
                    break;
                case 'Average':
                    $strDefaultDesc = TXT_UCF('AVERAGE');
                    break;
                case 'Good':
                    $strDefaultDesc = TXT_UCF('GOOD');
                    break;
                case 'Specialist':
                    $strDefaultDesc = TXT_UCF('SPECIALIST');
                    break;
                case 'Yes':
                    $strDefaultDesc = TXT_UCF('YES');
                    break;
                case 'No':
                    $strDefaultDesc = TXT_UCF('NO');
                    break;
                default:
                    $strDefaultDesc = '';
            }

            $scalesHtml .= '
                                    <tr>
                                        <td>&nbsp;' . $queryResult_row['scale_name'] . '</td>
                                        <td>' . $strDefaultDesc . '</td>
                                        <td>' . $set_default . '</td>
                                        <td>
                                            <input name="desc' . $i . '" id="desc' . $i . '" type="text" value="' . $queryResult_row['description'] . '" size="25" ' . $disable_check . '>
                                        </td>
                                        <td>';
                                        if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                                            $scalesHtml .= '<input name="spread' . $i . '" id="spread' . $i . '" type="text" value="' . $queryResult_row['score_spread'] . '" size="5" ' . $disable_check . '>';
                                        } else {
                                            $scalesHtml .= '&nbsp;';
                                        }
                                            $scalesHtml .= '
                                        </td>
                                        <td>';
                                        if (CUSTOMER_OPTION_USE_FINAL_RESULT && $i <= $lastNumericScore) {
                                            $scalesHtml .= '<input name="desc_final' . $i . '" id="desc_final' . $i . '" type="text" value="' . $queryResult_row['total_score_description'] . '" size="25" ' . $disable_check . '>';
                                        } else {
                                            $scalesHtml .= '&nbsp;';
                                        }
                            $scalesHtml .= '
                                        </td>
                                    </tr>';
                            $i++;
                        }
                        $scalesHtml .= '
                                </table>
                                <br />
                                <div>
                                    <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                                </div>
                                ';

        $scalesBlock = BaseBlockHtmlInterfaceObject::create($scalesTitle, 900);
        $scalesBlock->setContentHtml($scalesHtml);


        $html = '
        <div id="mode_department">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                    <td>
                        <div id="divRight">
                            <form id="scaleForm" name="scaleForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
                                ' . $safeFormHandler->getTokenHiddenInputHtml() . '
                                <table align="center">
                                    <tr>
                                        <td>

                                            ' . $scalesBlock->fetchHtml() . '
                                            <br/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_SCALES));
    }
    return $objResponse;
}


function options_processSafeForm_editScaleValues($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_SCALE_DESCRIPTION)) {

        // TODO: validatie!!
        // TODO: eerst data uit form halen, dan pas naar query. geen retrieve in queries gebruiken

        $hasError = true;
        BaseQueries::startTransaction();
        $lastNumericScore = 5;
        for ($i = 1; $i <= 7; $i++) {  // hbd: 7?

            $description = $safeFormHandler->retrieveInputValue('desc' . $i);
            if (CUSTOMER_OPTION_USE_FINAL_RESULT && $i <= $lastNumericScore) {
                $descriptionTotalScore = $safeFormHandler->retrieveInputValue('desc_final' . $i);
                $sql_descriptionTotalScore = '"' . mysql_real_escape_string($descriptionTotalScore) . '"';
            } else {
                $sql_descriptionTotalScore = 'total_score_description' ; // kolom aan zichzelf toekennen in query
            }
            $spread = $safeFormHandler->retrieveInputValue('spread' . $i);
            // TODO: nette foutcontrole en ditto melding
            if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
                $score_spread = is_numeric($spread) ? $spread : 'score_spread';
            } else {
                $score_spread = 'score_spread' ; // kolom aan zichzelf toekennen in query
            }

            $sql = 'UPDATE
                        scale
                    SET
                        description             = "' . mysql_real_escape_string($description) . '",
                        total_score_description = ' . $sql_descriptionTotalScore . ',
                        score_spread            = ' . $score_spread . '
                    WHERE
                        scale_id = ' . $i . '
                        AND customer_id = ' . CUSTOMER_ID;
            BaseQueries::performUpdateQuery($sql);
        }
        BaseQueries::finishTransaction();
        $hasError = false;

        $message = TXT_UCF('SUCCESSFULLY_SAVED');
    }
    return array($hasError, $message);
}



?>
