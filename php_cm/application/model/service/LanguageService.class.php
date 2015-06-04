<?php

/**
 * Description of LanguageService
 *
 * @author ben.dokter
 */

require_once('application/model/value/language/LanguageTranslationValue.class.php');
require_once('application/library/PamExceptionProcessor.class.php');

class LanguageService
{

    static function getTextForLabel($textLabel, $languageId)
    {
        $matchLabel = empty($textLabel) ? 'NULL' : $textLabel;
        // hulpje voor de programmeur om niet gedefinieerde setjes van woorden te checken...
        if (APPLICATION_CHECK_AND_FAIL_UNFOUND_WORDS) {
            $textNL = @constant('LanguageTranslationValue::nl__' . $matchLabel);
            $textEV = @constant('LanguageTranslationValue::ev__' . $matchLabel);
            $textEN = @constant('LanguageTranslationValue::en__' . $matchLabel);
            // onderstaande is leuk maar alleen zinvol als de warnings hierboven geen exceptie opleveren via de warning_handler.
            // toch maar laten staan omdat de omgevinginstellingen anders kunnen zijn...
            if (empty($textNL) || empty($textEV) || empty($textEN)) {
                $errorMessage  = 'LanguageService:getTextForLabel, fail $textLabel: ' . "\n";
                $errorMessage .= empty($textNL) ? 'nl__' . $matchLabel . "\n" : '';
                $errorMessage .= empty($textEV) ? 'ev__' . $matchLabel . "\n" : '';
                $errorMessage .= empty($textEN) ? 'en__' . $matchLabel . "\n" : '';

                TimecodeException::raise($errorMessage, PamExceptionCodeValue::LANGUAGE_INCOMPLETE);
            }
        }

        switch($languageId) {
            case LanguageValue::LANG_ID_EN:
                $text = @constant(@'LanguageTranslationValue::en__' . $matchLabel);
                break;
            case LanguageValue::LANG_ID_EVC:
                $text = @constant(@'LanguageTranslationValue::ev__' . $matchLabel);
                break;
            case LanguageValue::LANG_ID_NL:
            default:
                $text = @constant(@'LanguageTranslationValue::nl__' . $matchLabel);
                break;
        }
        if (empty($text)) {
            $text = APPLICATION_SHOW_UNLOADED_WORDS ? '|*' . $matchLabel . '*|' : '';
        }
        return $text;
    }
}

?>
