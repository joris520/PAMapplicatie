<?php

require_once('application/library/PamExceptionProcessor.class.php');

class SafeLinkHandler {

    // Input format
    const INPUT_FORMAT_NAME     = 'input_format_name';
    const INPUT_FORMAT_PREFIX   = 'input_format_prefix';
    const INPUT_FORMAT_TYPE     = 'input_format_type';
    const INPUT_FORMAT_OPTIONAL = 'input_format_optional';

    const HIDDEN_INPUT_TOKEN    = 'token';

    const INPUT_FORMAT_TYPE_INTEGER          = 'i';
    const INPUT_FORMAT_TYPE_STRING           = 's';
    const INPUT_FORMAT_TYPE_ARRAY_OF_INTEGER = 'ai';
    const INPUT_FORMAT_TYPE_ARRAY_OF_STRING  = 'as';

    const SESSION_SAFEFORM_STORE  = 'SessionSafeLinkStore';

    private $s_linkIdentifier;
    private $a_inputFormats;
    private $a_cleanLinkValues;
    private $s_uniqToken;
    private $b_invalidInputFound;
    private $s_errorMessage;
    private $as_errorLinkValues;

    function __construct($s_linkIdentifier, $keep_linkIdenfier = NULL) {
        $this->clearSafeLinkStore($keep_linkIdenfier);
        $this->s_linkIdentifier = $s_linkIdentifier;
        $this->a_inputFormats = array();
        $this->a_linkValues = array();
        $this->a_cleanLinkValues = array();
        $this->s_uniqToken = '';
        $this->s_errorMessage = '';
        $this->as_errorLinkValues = '';
        $this->initializeSafeLinkHandler();
    }

    static function createSafeLinkHandler($s_linkIdentifier, $keep_linkIdenfier = NULL)
    {
        return new SafeLinkHandler($s_linkIdentifier, $keep_linkIdenfier);
    }
    //////////////////// static stuff

    static function retrieveSafeLinkHandler($linkIdentifier)
    {
        $safeLinkHandler = unserialize(self::retrieveFromSession($linkIdentifier));

        return array(is_object($safeLinkHandler), $safeLinkHandler);
    }

    static function getValidatedSafeLinkHandler($linkIdentifier, $linkToken, $linkValues)
    {
        $isValidLink = false;
        list($found, $safeLinkHandler) = self::retrieveSafeLinkHandler($linkIdentifier);

        if ($found) {
            $message = 'link voor ' . $linkIdentifier . ' gevonden';
            $isValidLink = $safeLinkHandler->validateAndCleanLink($linkIdentifier, $linkToken, $linkValues);
        } else {
            $message = 'geen opgeslagen link voor ' . $linkIdentifier;
        }
        return array($isValidLink, $safeLinkHandler, $message);
    }

    static function finalizeSafeLinkProcess () {
        self::clearSafeLinkStore();
    }


    //////////////////// public stuff

    public function finalizeDataDefinition()
    {
        // Zet in sessie. Gebruik als linkIdentifier als key/index
        self::storeInSession($this->s_linkIdentifier, serialize($this));
    }


    public function getTokenHiddenInputHtml()
    {
        $html = '';
        if (self::isStoredInSession($this->s_linkIdentifier)) {
            $html = '<input type="hidden" name="' . self::HIDDEN_INPUT_TOKEN . '" value="' . $this->s_uniqToken . '" />';
        } else {
            TimecodeException::raise('***** ' . $this->s_linkIdentifier . ': not yet called finalizeDataDefinition()', PamExceptionCodeValue::SAFEFORM_FINALIZE_ERROR);
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
        $this->a_cleanLinkValues[$s_name] = $s_value;
    }

    public function retrieveSafeValue($s_name)
    {
        return $this->a_cleanLinkValues[$s_name];
    }

    // TODO: specifiek voor type om betere controle en error reporting mogelijk te maken
    // retrieveStringInputValue, retrieveIntegerInputValue
    public function retrieveInputValue($s_name)
    {
        // TODO: check op cleaned en juiste type! anders pamexceptie
        return $this->a_cleanLinkValues[$s_name];
    }

    public function getLinkIdentifier()
    {
        return $this->s_linkIdentifier;
    }

    public function getToken()
    {
        return $this->s_uniqToken;
    }

    public function getErrorText()
    {
        return $this->s_errorMessage . ' ' . $this->as_errorLinkValues;
    }

    public function getErrorMessage()
    {
        return $this->s_errorMessage;
    }

    public function getErrorLinkValues()
    {
        return $this->as_errorLinkValues;
    }

    public function getInputFormats()
    {
        return $this->a_inputFormats;
    }

    public function retrieveCleanedValues()
    {
        return $this->a_cleanLinkValues;
    }




    //////////////////// private stuff

    private function isStoredInSession($linkIdentifier)
    {
        return !empty($_SESSION[self::SESSION_SAFEFORM_STORE][$linkIdentifier]);
    }
    private function retrieveFromSession($linkIdentifier)
    {
        return $_SESSION[self::SESSION_SAFEFORM_STORE][$linkIdentifier];
    }

    private function storeInSession($linkIdentifier, $serialized)
    {
        $_SESSION[self::SESSION_SAFEFORM_STORE][$linkIdentifier] = $serialized;
    }

    private function initializeSafeLinkHandler()
    {
        $uniqId = uniqid(mt_rand(), true);
        $this->s_uniqToken = $uniqId;
    }

    private function clearSafeLinkStore($keep_linkIdentifier = NULL)
    {
        if (!empty($keep_linkIdentifier)) {
            $serialized = self::retrieveFromSession($keep_linkIdentifier);
        }
        unset($_SESSION[self::SESSION_SAFEFORM_STORE]);
        if (!empty($keep_linkIdentifier)) {
            self::storeInSession($keep_linkIdentifier, $serialized);
        }
    }

    private function isValidLinkSubmission($linkIdentifier, $link_token) {
        $isValidLinkSubmission = false;

        if (strcmp($this->s_uniqToken, $link_token) == 0 &&
            strcmp($this->s_linkIdentifier, $linkIdentifier) == 0) {
            $isValidLinkSubmission = true;
        }

        return $isValidLinkSubmission;
    }

    private function cleanInputByName($s_name, $s_type, $b_optional, $as_link_value)
    {
        $value = '';

        if (!is_array($as_link_value) && !empty($as_link_value)) {
            $as_link_value = trim($as_link_value);
        }

        switch($s_type) {
            case self::INPUT_FORMAT_TYPE_STRING:
                // TODO: niet uit moduleUtils, en htmlspecialchars ??
                $value = ModuleUtils::filterHTMLTags($as_link_value);
                break;
            case self::INPUT_FORMAT_TYPE_INTEGER:
                if (is_numeric($as_link_value)) {
                    $value = intval($as_link_value);
                }
                break;
//            case self::INPUT_FORMAT_TYPE_NUMERIC:
//                if (is_numeric($as_link_value)) {
//                    $value = $as_link_value; // TODO: filtering?
//                }
//                break;
            case self::INPUT_FORMAT_TYPE_ARRAY_OF_INTEGER:
                if (is_array($as_link_value)) {
                    $a_cleaned_input = array();
                    foreach ($as_link_value as $value) {
                        $a_cleaned_input[] = $this->cleanInputByName($s_name, self::INPUT_FORMAT_TYPE_INTEGER, $b_optional, $value);
                    }
                    $value = $a_cleaned_input;
                }
                break;
            case self::INPUT_FORMAT_TYPE_ARRAY_OF_STRING:
                if (is_array($as_link_value)) {
                    $a_cleaned_input = array();
                    foreach ($as_link_value as $key => $value) {
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
                    $this->as_errorLinkValues = $as_link_value;
                }
        }
        return $value;
    }

    private function cleanInputByPrefix($s_prefix, $s_type, $a_link_values) {
        $keys = preg_grep('/'.  $s_prefix . '[0-9]+/', array_keys( $a_link_values ));

        $a_cleaned_prefix_inputs = array();

        foreach ($keys as $key) {
            $a_cleaned_prefix_inputs[$key] = $this->cleanInputByName($key, $s_type, false, $a_link_values[$key]);
        }

        return $a_cleaned_prefix_inputs;
    }

    private function cleanInput($a_link_values) {
        $this->b_invalidInputFound = false;

        foreach($this->a_inputFormats as $input_format) {
            if (!empty($input_format[self::INPUT_FORMAT_NAME])) {
                $this->a_cleanLinkValues[$input_format[self::INPUT_FORMAT_NAME]] =
                        $this->cleanInputByName($input_format[self::INPUT_FORMAT_NAME],
                                                $input_format[self::INPUT_FORMAT_TYPE],
                                                $input_format[self::INPUT_FORMAT_OPTIONAL],
                                                $a_link_values[$input_format[self::INPUT_FORMAT_NAME]]);
            } elseif (!empty($input_format[self::INPUT_FORMAT_PREFIX])) {
                $a_temp_array = array();

                $a_temp_array = $this->cleanInputByPrefix($input_format[self::INPUT_FORMAT_PREFIX],
                                                          $input_format[self::INPUT_FORMAT_TYPE],
                                                          $a_link_values);

                $this->a_cleanLinkValues = array_merge($this->a_cleanLinkValues, $a_temp_array);
            }
        }

        return !$this->b_invalidInputFound;
    }

    private function validateAndCleanLink($linkIdentifier, $linkToken, $a_linkValues)
    {
        $isValidLink = false;

        $link_token = $linkToken;
        if (empty($link_token)) {
            $this->s_errorMessage = '** Token not found for  '. $linkIdentifier;
        } else {
            if ($this->isValidLinkSubmission($linkIdentifier, $link_token)) {
                $isValidLink = $this->cleanInput($a_linkValues);
            } else {
                $this->s_errorMessage = '** Token '. $link_token . ' not valid for '. $linkIdentifier;
            }
        }
        return $isValidLink;
    }

}

?>
