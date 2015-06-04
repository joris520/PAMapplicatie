<?php

require_once('application/model/service/LanguageService.class.php');


    /* functie om de tekst met het gewenste label en in de default formattering op te halen */
    function TXT($textLabel) {
        return LanguageService::getTextForLabel($textLabel, LANG_ID);
    }

    /* functie om de tekst met het gewenste label en in de UPPERCASE formattering op te halen */
    function TXT_UC($textLabel) {
        return strtoupper(TXT($textLabel));
    }

    /* functie om de tekst met het gewenste label en in de LOWERCASE formattering op te halen */
    function TXT_LC($textLabel) {
        return strtolower(TXT($textLabel));
    }

    /* functie om de tekst met het gewenste label en in de Uppercase eerste letter formattering op te halen */
    function TXT_UCF($textLabel) {
        return ucfirst(TXT($textLabel));
    }

    function TXT_UCF_LANG($textLabel, $languageId) {
        return ucfirst(LanguageService::getTextForLabel($textLabel, $languageId));
    }

    /* functie om de tekst met het gewenste label en in de Upper Case Woord formattering op te halen */
    function TXT_UCW($textLabel) {
        return ucwords(TXT($textLabel));
    }

    // Buttons hebben altijd alle woorden UC
    function TXT_BTN($textLabel) {
        return ucwords(TXT($textLabel));
    }

    function TXT_TAB($textLabel) {
        // voor de menu koppen spaties door &nbsp en - door &minus om afbreken te voorkomen (in IE)
        return str_replace( array(' ', '-'),
                            array('&nbsp;', '&minus;'),
                            TXT_UC($textLabel));
    }

    // vervang meedere %VALUE% in een label door de opgegeven waarden.
    function TXT_UCF_VALUE( $textLabel,
                            $values = array(CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER),
                            $replacers = array('%NUMBER%'))
    {
        return str_replace($replacers, $values, TXT_UCF($textLabel));
    }

?>