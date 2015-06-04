<?php


/**
 * Description of InterfaceBuilderComponents
 *
 * @author ben.dokter
 */

require_once('gino/DateUtils.class.php');

class InterfaceBuilderComponents
{
    const CALENDAR_INPUT_READONLY   = true;
    const CALENDAR_INPUT_EDIT       = false;

    const CALENDAR_INPUT_NO_CLASS   = '';

    static function getCalendarInputPopupHtml(  $inputName,
                                                $databaseDate,
                                                $inputClass = self::CALENDAR_INPUT_NO_CLASS,
                                                $readOnly = self::CALENDAR_INPUT_READONLY,
                                                $onChangeFunction = NULL,
                                                $prefixFunctions = NULL)
    {
        $readOnlyTag = $readOnly ? ' readonly' : '';
        $onChangeTag = empty($onChangeFunction) ? '' : 'onChange="' . $onChangeFunction .'"';
        $prefixFunctionTag = empty($prefixFunctions) ? '' : $prefixFunctions;
        $html  = '<input id="' . $inputName . '" name="' . $inputName . '" class="' . $inputClass . '" type="text" size="10" value="' . DateUtils::convertToInputDate($databaseDate). '"' . $readOnlyTag . ' ' . $onChangeTag . '>&nbsp;';
        $html .= InterfaceBuilder::IconLink($inputName . '_cal',
                                            TXT_UCW('DATE_PICKER'),
                                            $prefixFunctionTag . 'showCalendarInPopup(\'' . $inputName . '\', ' . JS_DEFAULT_DATE_FORMAT . ');',
                                            ICON_CALENDAR);
        return $html;
    }

    static function getCalendarInputHtml(   $inputName,
                                            $databaseDate,
                                            $inputClass = self::CALENDAR_INPUT_NO_CLASS,
                                            $readOnly = self::CALENDAR_INPUT_READONLY,
                                            $onChangeFunction = NULL,
                                            $prefixFunctions = NULL)
    {
        $readOnlyTag = $readOnly ? ' readonly' : '';
        $onChangeTag = empty($onChangeFunction) ? '' : 'onChange="' . $onChangeFunction .'"';
        $prefixFunctionTag = empty($prefixFunctions) ? '' : $prefixFunctions;
        $html  = '<input id="' . $inputName . '" name="' . $inputName . '" class="' . $inputClass . '" type="text" size="10" value="' . DateUtils::convertToInputDate($databaseDate). '"' . $readOnlyTag . ' ' . $onChangeTag . '>&nbsp;';
        $html .= InterfaceBuilder::IconLink($inputName . '_cal',
                                            TXT_UCW('DATE_PICKER'),
                                            $prefixFunctionTag . 'showCalendar(\'' . $inputName . '\', ' . JS_DEFAULT_DATE_FORMAT . ');',
                                            ICON_CALENDAR);
        return $html;
    }

    static function getCalendarLink($calendarName)
    {
        return '<em>deprecated:</em>'.
                InterfaceBuilder::IconLink(  $calendarName . '_cal',
                                            TXT_UCW('DATE_PICKER'),
                                            'showCalendarInPopup(\'' . $calendarName . '\', ' . JS_DEFAULT_DATE_FORMAT . ');',
                                            ICON_CALENDAR);
    }

    function getEditPrefix($scale, $prefix)
    {
        // de infix is bedoeld voor iMacros scripts
        if ($scale == ScaleValue::SCALE_Y_N) {
            $row_name_infix = 'yn';
        } else {
            $row_name_infix = 'num';
        }
        return $prefix . $row_name_infix;
    }

    static function getEditScoreHtml($input_name, $scale, $score, $isEmptyAllowed = false)
    {
        $html = '';

        if ($scale == ScaleValue::SCALE_Y_N) {
            $checked_scale_y  = $score == ScoreValue::SCORE_Y ? ' checked ' : '';
            $checked_scale_n  = $score == ScoreValue::SCORE_N ? ' checked ' : '';
            $checked_scale_NA = $score == ScoreValue::SCORE_NA ? ' checked ' : '';

            $optionsHtml = '
                <input type="radio" name="' . $input_name . '" value="' . ScoreValue::SCORE_Y . '" ' . $checked_scale_y . $onChange . '>' . TXT_UCF('YES') . '
                <input type="radio" name="' . $input_name . '" value="' . ScoreValue::SCORE_N . '" ' . $checked_scale_n . $onChange . '>' . TXT_UCF('NO');
            if ($isEmptyAllowed) {
                $optionsHtml .= '
                <input type="radio" name="' . $input_name . '" value="' . ScoreValue::INPUT_SCORE_NA . '" ' . $checked_scale_NA . $onChange . '>' . TXT('NA');
            }
        } else { // ScaleValue::SCALE_1_5
            $optionsHtml = '';
            for ($scoreNum = ScoreValue::MIN_NUM_SCORE; $scoreNum <= ScoreValue::MAX_NUM_SCORE; $scoreNum++) {
                $option_checked = ($score == $scoreNum) ? ' checked ' : '';
                $optionsHtml .= '<input type="radio" name="' . $input_name . '" value="' . $scoreNum . '"' . $option_checked . $onChange . '>' . $scoreNum . '&nbsp;';
            }
            if ($isEmptyAllowed) {
                $option_checked = $score == ScoreValue::SCORE_NA ? 'checked ' : '';
                $optionsHtml .= '<input type="radio" name="' . $input_name . '" value="' . ScoreValue::INPUT_SCORE_NA . '" ' . $option_checked . $onChange . '>' . TXT('NA');
            }
        }
        $html = $optionsHtml;
        return $html;
    }

    static function getEditNoteHtml($input_name, $note)
    {
        return '<textarea name="' . $input_name . '" id="' . $input_name . '" style="height:50px;" cols="60">' . $note . '</textarea>';
    }

    // TODO: betere plek...
    static function getScoreLegendaHtml()
    {
        return '<strong>' . TXT_UCF('SCALE') . ' : </strong>' .
               '[1]-' . SCALE_NONE . '&nbsp;&nbsp;' .
               '[2]-' . SCALE_BASIC . '&nbsp;&nbsp;' .
               '[3]-' . SCALE_AVERAGE . '&nbsp;&nbsp;' .
               '[4]-' . SCALE_GOOD . '&nbsp;&nbsp;' .
               '[5]-' . SCALE_SPECIALIST;
    }

    static function getFinalResultLegendaHtml()
    {
        $labels = array();
        $labels[1] = FINAL_SCALE_NONE;
        $labels[2] = FINAL_SCALE_BASIC;
        $labels[3] = FINAL_SCALE_AVERAGE;
        $labels[4] = FINAL_SCALE_GOOD;
        $labels[5] = FINAL_SCALE_SPECIALIST;

        $legenda = '<strong>' . TXT_UCF('SCALE') . ' : </strong>';
        foreach($labels as $key => $label) {
            if (!empty($label)) {
                $legenda .= '[' . $key . ']-' . $label . '&nbsp;&nbsp;';
            }
        }

        return $legenda;
    }

    // TODO: refactor!
    static function getAttachmentLink($employee_id, $document_id)
    {
        $attachmentLink = '';
        if (!empty($employee_id) && !empty($document_id)) {
            $attachmentResult = DocumentQueries::getEmployeesDocumentInfo($document_id, $employee_id);
            $attachment = mysql_fetch_assoc($attachmentResult);
            if (!empty($attachment['id_contents']) && !empty($attachment['document_name'])) {
                $attachmentLink = '<a href="downloaddb.php?d=' . $attachment['id_contents'] . '&e=' . $employee_id . '">' . $attachment['document_name'] . '</a>';
            }
        }
        return $attachmentLink;
    }

    static function getEmployeesSelectorHtml($selectEmployees)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/select/selectEmployees.tpl');
        // vullen template
        $selectEmployees->fillComponent($template);
        return $smarty->fetch($template);
    }
}

?>
