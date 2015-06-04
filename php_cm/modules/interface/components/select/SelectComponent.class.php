<?php
/**
 * Description of SelectComponent
 *
 * @author mendel.van.t.riet
 */
abstract class SelectComponent {

    protected $errorTxt = '';

    // vult variablen in de smarty-template
    public abstract function fillComponent(&$smarty_tpl);

    // valideer input, vult errorTxt en geeft true/false terug
    public abstract function validateFormInput($FORM_array);

    public abstract function processResults($FORM_array);

    // geeft array met resultaten terug
    public abstract function getResults();

    public function getErrorTxt()
    {
        return $this->errorTxt;
    }

}
?>
