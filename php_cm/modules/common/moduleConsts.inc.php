<?php
/*
 * Ter voorkoming van magic numbers in de code
 */

// todo: include verplaatsen
require_once('application/model/value/databaseValueConsts.inc.php');



//define('HISTORYMODE_FUNCTION',   'function');
//define('HISTORYMODE_COMPETENCE', 'competence');
define('EMPTY_CLUSTER_LABEL', '-');
//define('ASSESSMENT_EVALUATION_ATTACHMENT_CLUSTER', 'EVALUATION_ATTACHMENT');

define('DEFAULT_OPTION_ABBREVIATE', 100);
define('DEFAULT_ALERTDATE_OFFSET', -15);

define('EMPLOYEE_PDP_ACTION_ADD_WIZARD', 'employee_pdpaction_wizard');
define('EMPLOYEE_PDP_ACTION_ADD_WIZARD_FIXEDDATA', 'savedIds');
define('EMPLOYEE_PDP_ACTION_ADD_WIZARD_NAME', 'employee_pdpaction_wizard_name');

// competenties
define('KSP_INDENT', '&nbsp;&nbsp;&nbsp;&nbsp;');
define('SIGN_IS_KEY_COMP', '<span class="indicator" title="key"><strong>*</strong>&nbsp;</span>');
define('SIGN_IS_NOT_KEY_COMP', '&nbsp;&nbsp;');

define('SIGN_IS_MAIN_COMP', '&nbsp;');
define('SIGN_IS_NOT_MAIN_COMP', '&nbsp;');

define('SIGN_COMP_ADDITIONAL_PROFILE', '<span class="indicator" title="additional" style="font-weight:normal">&oplus;</span>');
define('REQUIRED_FIELD_INDICATOR', '<span class="indicator">*</span>');

// is nu naar customer option: CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER.
// default 300, aanpasbaar per customer (bijv. customers met 350 medewerkers)
//
// define('DEFAULT_EMPLOYEES_SHOW_LIMIT', 350);


// bijhouden geselecteerden in sessie
define('SESSION_SELECTED_PDP_TASKOWNER',          'selected_pdp_taskowner');
define('SESSION_SEARCH_TEXT_PDP_TASKOWNER',       'search_text_pdp_taksowner');
define('SESSION_SELECTED_THEESIXTY_DEGREES',      'selected_threesixty_degrees');
define('SESSION_SEARCH_TEXT_THEESIXTY_DEGREES',   'search_text_threesixty_degrees');


// aantal open vragen
//define('MISC_QUESTIONS_MINIMUM', 7);


define('SHOW_NO_SCORES_FOR_COMPETENCES',     0);
define('SHOW_NO_MAIN_JOB_PROFILE',           '');

define('DO_NOT_SHOW_LAST_MODIFIED',          false);
define('SHOW_LAST_MODIFIED',                 true);


define('DO_NOT_USE_EVALUATOR_INFO', false);

define('DO_NOT_USE_BCC_HEADER_FIELD', '');

define('DO_NOT_USE_HASH_ID', '');

//define('EVALUATION_ATTACHMENT_CLUSTER_NAME', 'Functioneringsgesprek');

define('THREESIXTY_COMPETENCES_SHOW_INPUT',                     true);
define('THREESIXTY_COMPETENCES_SHOW_VIEW',                      false);
define('THREESIXTY_COMPETENCES_DO_NOT_SHOW_COMPETENCE_DETAILS', false);

// De 360 message types die niet in de database staan maar intern gebruikt worden
define('THREESIXTY_MESSAGE_TYPE_REMINDER1',  21);
define('THREESIXTY_MESSAGE_TYPE_REMINDER2',  22);

// TODO: component specifieke defines naar component
// Selecteer medewerkers
define('EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION', 1);
define('EMPLOYEE_SELECT_DEPARTMENT',                       2);
define('EMPLOYEE_SELECT_JOB_PROFILE',                      3);
define('EMPLOYEE_SELECT_JOB_PROFILE_WITHIN_DEPARTMENT',    4);
define('EMPLOYEE_SELECT_ALL_EMPLOYEES',                    5);
define('EMPLOYEE_SELECT_EMPLOYEES_AGAINST_JOB_PROFILE',    6);
define('EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER',           7);
define('EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER_NEW',       8);
define('EMPLOYEE_SELECT_DEPARTMENT_NEW',                   9);

define('EMPLOYEE_SELECT_TRIGGER_SOURCE_OPTION_CHANGE', 0);
define('EMPLOYEE_SELECT_TRIGGER_SOURCE_FILTER_CHANGE', 1);

// Filters voor medewerkers
define('FILTER_EMPLOYEES_ALPHABETICAL', 0);
//define('FILTER_EMPLOYEES_NOTHING', 0);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED',                        1);
define('FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED',                    2);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_EMPLOYEE_NOT_FILLED_IN', 3);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_MANAGER_NOT_FILLED_IN',  4);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN',         5);
define('FILTER_EMPLOYEES_ASSESSMENT_STATE',                        6);
define('FILTER_EMPLOYEES_TODO_EVALUATION',                         7);
define('FILTER_EMPLOYEES_DONE_EVALUATION',                         8);
define('FILTER_EMPLOYEES_NO_EVALUATION',                           9);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_MANAGER_COMPLETED',      10);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS',  11);
define('FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS',                 12);
define('FILTER_EMPLOYEES_ASSESSMENT_LAST',                         12); // last indicator

define('FILTER_EMPLOYEES_STATUS_MANAGER_PRELIMINARY',              13);
define('FILTER_EMPLOYEES_STATUS_MANAGER_FINAL',                    14);

// de status van de assessment in filter
// Heeft de manager/medewerker de assessment ingevuld
define('ASSESSMENT_STATUS_NOT_USED',         0);
define('EMPLOYEE_FILLED_IN_ASSESSMENT',      1);
define('MANAGER_NOT_FILLED_IN_ASSESSMENT',   3);
define('EMPLOYEE_NOT_FILLED_IN_ASSESSMENT',  4);
define('MANAGER_FILLED_IN_ASSESSMENT',       8);
define('INVITED_ASSESSMENT',                 9);
define('NEVER_INVITED_ASSESSMENT',           10);
define('NOT_INVITED_ASSESSMENT_THIS_PERIOD', 11);

// assessment status sort order
define('SORTORDER_ASSESSMENT_STATUS_UNUSED', 990);
define('SORTORDER_NOT_INVITED_ASSESSMENT_THIS_PERIOD', 999);
define('SORTORDER_STATUS_EVALUATION_DONE', 40);


define('PRINT_OPTION_ACTION',           1);
define('PRINT_OPTION_TASK',             2);
define('PRINT_OPTION_ACTION_AND_TASK',  3);

// batch pdp actions
define('SELECT_PDP_ACTION_OWNER_BOSS', 1);
define('SELECT_PDP_ACTION_OWNER_EMPLOYEE', 2);

?>
