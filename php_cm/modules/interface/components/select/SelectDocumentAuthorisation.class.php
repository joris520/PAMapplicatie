<?php
/**
 * Het SelectDocumentAuthorization object.
 *
 * @author ben.dokter
 *
 */

require_once('modules/common/moduleConsts.inc.php');
require_once('modules/common/moduleUtils.class.php');
require_once('SelectComponent.class.php');
require_once('gino/MysqlUtils.class.php');

class SelectDocumentAuthorisation extends SelectComponent {

    protected $mysqlQuery = "";
    protected $validQuery = false;

    // edit
    protected $document_id;
    protected $doc_authorisation_levels;

    // results
    protected $selected_document_userlevel_hr;
    protected $selected_document_userlevel_mgr;
    protected $selected_document_userlevel_emp_edit;
    protected $selected_document_userlevel_emp_view;

    // verwachte form values
    private $select_field_hr  = 'doc_userlevel_hr';
    private $select_field_mgr = 'doc_userlevel_mgr';
    private $select_field_emp = 'doc_userlevel_emp';

    // instellen voor edit
    public function setDocumentId($document_id) {
        $this->document_id = $document_id;
    }

    public function setAuthorisationLevels($doc_authorisation_levels) {
        $this->doc_authorisation_levels = $doc_authorisation_levels;
    }

    public function fillComponent(&$smarty_tpl)
    {
        if (!empty ($this->document_id)) {
            $sql = 'SELECT
                        level_id_hr,
                        level_id_mgr,
                        level_id_emp_edit
                    FROM
                        employees_documents
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EDOC = ' . $this->document_id;
            $get_doc_authorisation_query = BaseQueries::performQuery($sql);
            $doc_authorisation_levels = @mysql_fetch_assoc($get_doc_authorisation_query);
        } else {
            // default bij nieuw: alles aan
            if (empty($this->doc_authorisation_levels)) {
                $doc_authorisation_levels = array('level_id_hr'       => UserLevelValue::HR,
                                                  'level_id_mgr'      => UserLevelValue::MANAGER,
                                                  'level_id_emp_edit' => UserLevelValue::EMPLOYEE_EDIT);
            } else {
                $doc_authorisation_levels = $this->doc_authorisation_levels;
                $doc_authorisation_levels = array('level_id_hr'       => $this->doc_authorisation_levels['selected_hr'],
                                                  'level_id_mgr'      => $this->doc_authorisation_levels['selected_mgr'],
                                                  'level_id_emp_edit' => $this->doc_authorisation_levels['selected_emp_edit']);
            }
        }

        // array voor hr
        $auth_level_hr       = array('selected_id' => $doc_authorisation_levels['level_id_hr'],
                                     'level_id' => UserLevelValue::HR,
                                     'display_name' => UserLevelConverter::display(UserLevelValue::HR),
                                     'input_field_id' =>  $this->select_field_hr);

        // array voor mgr
        $auth_level_mgr      = array('selected_id' => $doc_authorisation_levels['level_id_mgr'],
                                     'level_id' => UserLevelValue::MANAGER,
                                     'display_name' => UserLevelConverter::display(UserLevelValue::MANAGER),
                                     'input_field_id' =>  $this->select_field_mgr);

        // array voor emp
        $auth_level_emp_edit = array('selected_id' => $doc_authorisation_levels['level_id_emp_edit'],
                                     'level_id' => UserLevelValue::EMPLOYEE_EDIT,
                                     'display_name' => UserLevelConverter::display(UserLevelValue::EMPLOYEE_EDIT, false),
                                     'input_field_id' =>  $this->select_field_emp);

        $smarty_tpl->assign('authorisations', array($auth_level_hr, $auth_level_mgr, $auth_level_emp_edit));
    }

    // verwachte form values: zie definities bovenin
    public function validateFormInput($FORM_array)
    {
        $this->errorTxt = "";
        $this->selected_document_userlevel_hr  = ($FORM_array[$this->select_field_hr] == UserLevelValue::HR) ? UserLevelValue::HR : '' ;
        $this->selected_document_userlevel_mgr = ($FORM_array[$this->select_field_mgr] == UserLevelValue::MANAGER) ? UserLevelValue::MANAGER : '' ;
        $this->selected_document_userlevel_emp_edit = ($FORM_array[$this->select_field_emp] == UserLevelValue::EMPLOYEE_EDIT) ? UserLevelValue::EMPLOYEE_EDIT : '' ;
        // employee maakt in selectie scherm geen onderscheid... view dus als emp_edit overnemen
        $this->selected_document_userlevel_emp_view = ($FORM_array[$this->select_field_emp] == UserLevelValue::EMPLOYEE_EDIT) ? UserLevelValue::EMPLOYEE_VIEW : '' ;

        return true;
    }

    // verwachte form values: zie definities bovenin
    public function processResults($FORM_array)
    {
        if ($this->validateFormInput($FORM_array)) {
            $results = $this->getResults();
        } else {
            $results = array();
        }

        return $results;
    }

    // fields in array:
    // - selected_hr, selected_mgr, selected_emp_edit, selected_emp_view
    public function getResults()
    {
        $results = array('selected_hr' =>  $this->selected_document_userlevel_hr,
                         'selected_mgr' => $this->selected_document_userlevel_mgr,
                         'selected_emp_edit' => $this->selected_document_userlevel_emp_edit,
                         'selected_emp_view' => $this->selected_document_userlevel_emp_view);

        return $results;
    }

}

?>
