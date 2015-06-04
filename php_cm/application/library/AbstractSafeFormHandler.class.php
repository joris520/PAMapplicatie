<?php

/**
 * Description of AbstractSafeFormHandler
 *
 * @author ben.dokter
 */

require_once('application/library/PamExceptionProcessor.class.php');

abstract class AbstractSafeFormHandler
{

    abstract static function retrieveAndValidate($formIdentifier, $formValues);

    // Input format
    const INPUT_FORMAT_NAME     = 'input_format_name';
    const INPUT_FORMAT_PREFIX   = 'input_format_prefix';
    const INPUT_FORMAT_TYPE     = 'input_format_type';
    const INPUT_FORMAT_OPTIONAL = 'input_format_optional';

    const HIDDEN_INPUT_TOKEN    = 'token';

    const INPUT_FORMAT_TYPE_INTEGER          = 'i';
    const INPUT_FORMAT_TYPE_STRING           = 's';
    const INPUT_FORMAT_TYPE_DISPLAYDATE      = 'd';
    const INPUT_FORMAT_TYPE_ARRAY_OF_INTEGER = 'ai';
    const INPUT_FORMAT_TYPE_ARRAY_OF_STRING  = 'as';

    private $safeFormStore;
    private $s_formIdentifier;
    private $a_inputFormats;
    private $a_cleanFormValues;
//    private $a_convertResultsFormValues;
    private $s_uniqToken;
    private $b_invalidInputFound;
    private $s_errorMessage;
    private $as_errorFormValues;

    /*protected*/ function __construct($safeFormStore, $s_formIdentifier, $keep_formIdenfier = NULL) {
        $this->safeFormStore = $safeFormStore;
        $this->clearSafeFormStore($keep_formIdenfier);
        $this->s_formIdentifier = $s_formIdentifier;
        $this->a_inputFormats = array();
        $this->a_formValues = array();
        $this->a_cleanFormValues = array();
        $this->s_uniqToken = '';
        $this->s_errorMessage = '';
        $this->as_errorFormValues = '';
        $this->initializeSafeFormHandler();
    }

    //////////////////// static stuff
    protected static function retrieveSafeFormHandlerAndProcessValues($sessionStore, $formIdentifier, $formValues)
    {
        $isValidForm = false;
        $safeFormHandler = unserialize($_SESSION[$sessionStore][$formIdentifier]);
        if (is_object($safeFormHandler)) {
            $message = 'form voor ' . $formIdentifier . ' gevonden';
            $isValidForm = $safeFormHandler->validateAndCleanForm($formIdentifier, $formValues);
        } else {
            $message = 'geen opgeslagen form voor ' . $formIdentifier;
        }
        return array($isValidForm, $safeFormHandler, $message);
    }


    //////////////////// public stuff


    function finalizeSafeFormProcess () {
        self::clearSafeFormStore();
    }


    public function finalizeDataDefinition()
    {
        // Zet in sessie. Gebruik als formIdentifier als key/index
        self::storeInSession($this->s_formIdentifier, serialize($this));
    }


    public function getTokenHiddenInputHtml()
    {
        $html = '';
        if (self::isStoredInSession($this->s_formIdentifier)) {
            $html = '<input type="hidden" name="' . self::HIDDEN_INPUT_TOKEN . '" value="' . $this->s_uniqToken . '" />';
        } else {
            TimecodeException::raise('***** ' . $this->s_formIdentifier . ': not yet called finalizeDataDefinition()', PamExceptionCodeValue::SAFEFORM_FINALIZE_ERROR);
        }
        return $html;
    }


    public function addIntegerInputFormatType($s_name, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_NAME     => $s_name,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_INTEGER,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addStringInputFormatType($s_name, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_NAME     => $s_name,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_STRING,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addDateInputFormatType($s_name, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_NAME     => $s_name,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_DISPLAYDATE,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addStringArrayInputFormatType($s_name, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_NAME     => $s_name,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_ARRAY_OF_STRING,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addIntegerArrayInputFormatType($s_name, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_NAME     => $s_name,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_ARRAY_OF_INTEGER,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addPrefixIntegerInputFormatType($s_prefix, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_PREFIX   => $s_prefix,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_INTEGER,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function addPrefixStringInputFormatType($s_prefix, $b_optional = false) {
        $this->a_inputFormats[] = array(self::INPUT_FORMAT_PREFIX   => $s_prefix,
                                        self::INPUT_FORMAT_TYPE     => self::INPUT_FORMAT_TYPE_STRING,
                                        self::INPUT_FORMAT_OPTIONAL => $b_optional
        );
    }

    public function storeSafeValue($s_name, $s_value)
    {
        $this->a_cleanFormValues[$s_name] = $s_value;
    }

    public function retrieveSafeValue($s_name, $b_isRequired = true)
    {
        if ($b_isRequired && is_null($this->a_cleanFormValues[$s_name])) {
            TimecodeException::raise('empty safeValue: ' . $s_name . ' on form: ' . $this->s_formIdentifier, PamExceptionCodeValue::SAFEFORM_ERROR);
        }
        return $this->a_cleanFormValues[$s_name];
    }

    // TODO: specifiek voor type om betere controle en error reporting mogelijk te maken
    // retrieveStringInputValue, retrieveIntegerInputValue
    public function retrieveInputValue($s_name)
    {
        // TODO: controleren op conversiefouten ivm goede foutmelding
        // TODO: check op cleaned en juiste type! anders pamexceptie
        return $this->a_cleanFormValues[$s_name];
    }

    public function retrieveDateValue($s_name)
    {
        // TODO: controleren op conversiefouten ivm goede foutmelding
        return $this->a_cleanFormValues[$s_name];
    }

    public function getFormIdentifier()
    {
        return $this->s_formIdentifier;
    }

    public function getToken()
    {
        return $this->s_uniqToken;
    }

    public function getErrorText()
    {
        return $this->s_errorMessage . ' ' . $this->as_errorFormValues;
    }

    public function getErrorMessage()
    {
        return $this->s_errorMessage;
    }

    public function getErrorFormValues()
    {
        return $this->as_errorFormValues;
    }

    public function getInputFormats()
    {
        return $this->a_inputFormats;
    }

    public function retrieveCleanedValues()
    {
        return $this->a_cleanFormValues;
    }




    //////////////////// private stuff

    private function isStoredInSession($formIdentifier)
    {
        return !empty($_SESSION[$this->safeFormStore][$formIdentifier]);
    }

    private function storeInSession($formIdentifier, $serialized)
    {
        $_SESSION[$this->safeFormStore][$formIdentifier] = $serialized;
    }

    private function retrieveFromSession($formIdentifier)
    {
        return $_SESSION[$this->safeFormStore][$formIdentifier];
    }

    private function initializeSafeFormHandler()
    {
        $uniqId = uniqid(mt_rand(), true);
        $this->s_uniqToken = $uniqId;
    }

    private function clearSafeFormStore($keep_formIdentifier = NULL)
    {
        if (!empty($keep_formIdentifier)) {
            $serialized = self::retrieveFromSession($keep_formIdentifier);
        }
        unset($_SESSION[$this->safeFormStore]);
        if (!empty($keep_formIdentifier)) {
            self::storeInSession($keep_formIdentifier, $serialized);
        }
    }

    private function isValidFormSubmission($formIdentifier, $form_token) {
        $isValidFormSubmission = false;

        if (strcmp($this->s_uniqToken, $form_token) == 0 &&
            strcmp($this->s_formIdentifier, $formIdentifier) == 0) {
            $isValidFormSubmission = true;
        }

        return $isValidFormSubmission;
    }

    private function cleanInputByName($s_name, $s_type, $b_optional, $as_form_value)
    {
        $value = '';

        if (!is_array($as_form_value) && !empty($as_form_value)) {
            $as_form_value = trim($as_form_value);
        }

        switch($s_type) {
            case self::INPUT_FORMAT_TYPE_STRING:
                // TODO: niet uit moduleUtils, en htmlspecialchars ??
                $value = ModuleUtils::filterHTMLTags($as_form_value);
                break;
            case self::INPUT_FORMAT_TYPE_INTEGER:
                if (is_numeric($as_form_value)) {
                    $value = intval($as_form_value);
                }
                break;
            case self::INPUT_FORMAT_TYPE_DISPLAYDATE:
                if (DateUtils::ValidateDisplayDate($as_form_value) == DateUtils::ValiDateCodeOK) {
                    $value = DateUtils::convertToDatabaseDate($as_form_value);
                }
                break;
//            case self::INPUT_FORMAT_TYPE_NUMERIC:
//                if (is_numeric($as_form_value)) {
//                    $value = $as_form_value; // TODO: filtering?
//                }
//                break;
            case self::INPUT_FORMAT_TYPE_ARRAY_OF_INTEGER:
                if (is_array($as_form_value)) {
                    $a_cleaned_input = array();
                    foreach ($as_form_value as $value) {
                        $a_cleaned_input[] = $this->cleanInputByName($s_name, self::INPUT_FORMAT_TYPE_INTEGER, $b_optional, $value);
                    }
                    $value = $a_cleaned_input;
                }
                break;
            case self::INPUT_FORMAT_TYPE_ARRAY_OF_STRING:
                if (is_array($as_form_value)) {
                    $a_cleaned_input = array();
                    foreach ($as_form_value as $key => $value) {
                        if (is_array($value)) {
                            $a_cleaned_input[$key] = $this->cleanInputByName($s_name, self::INPUT_FORMAT_TYPE_ARRAY_OF_STRING, $b_optional, $value);
                        } else {
                            $a_cleaned_input[$key] = $this->cleanInputByName($s_name, self::INPUT_FORMAT_TYPE_STRING, $b_optional, $value);
                        }
                    }

                    $value = $a_cleaned_input;
                }
                break;
            default:
                if (!$b_optional) {
                    $this->b_invalidInputFound = true;
                    $this->s_errorMessage = $s_name . ' ' . $s_type;
                    $this->as_errorFormValues = $as_form_value;
                }
        }
        return $value;
    }

    private function cleanInputByPrefix($s_prefix, $s_type, $a_form_values) {
        $keys = preg_grep('/'.  $s_prefix . '[0-9]+/', array_keys( $a_form_values ));

        $a_cleaned_prefix_inputs = array();

        foreach ($keys as $key) {
            $a_cleaned_prefix_inputs[$key] = $this->cleanInputByName($key, $s_type, false, $a_form_values[$key]);
        }

        return $a_cleaned_prefix_inputs;
    }

    private function cleanInput($a_form_values) {
        $this->b_invalidInputFound = false;

        foreach($this->a_inputFormats as $input_format) {
            if (!empty($input_format[self::INPUT_FORMAT_NAME])) {
                $this->a_cleanFormValues[$input_format[self::INPUT_FORMAT_NAME]] =
                        $this->cleanInputByName($input_format[self::INPUT_FORMAT_NAME],
                                                $input_format[self::INPUT_FORMAT_TYPE],
                                                $input_format[self::INPUT_FORMAT_OPTIONAL],
                                                $a_form_values[$input_format[self::INPUT_FORMAT_NAME]]);
            } elseif (!empty($input_format[self::INPUT_FORMAT_PREFIX])) {
                $a_temp_array = array();

                $a_temp_array = $this->cleanInputByPrefix($input_format[self::INPUT_FORMAT_PREFIX],
                                                          $input_format[self::INPUT_FORMAT_TYPE],
                                                          $a_form_values);

                $this->a_cleanFormValues = array_merge($this->a_cleanFormValues, $a_temp_array);
            }
        }

        return !$this->b_invalidInputFound;
    }

    private function validateAndCleanForm($formIdentifier, $a_formValues)
    {
        $isValidForm = false;

        $form_token = trim($a_formValues[self::HIDDEN_INPUT_TOKEN]);
        if (empty($form_token)) {
            $this->s_errorMessage = '** token not found for  '. $formIdentifier;
        } else {
            if ($this->isValidFormSubmission($formIdentifier, $form_token)) {
                $isValidForm = $this->cleanInput($a_formValues);
            } else {
                $this->s_errorMessage = '** Token '. $form_token . ' not valid in '. $formIdentifier;
            }
        }
        return $isValidForm;
    }

}

?>