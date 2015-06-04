<?php
// alphabetisch per tabel
// data values als constante in values opnemen

// application
require_once('application/model/value/IdValue.class.php');
require_once('application/model/value/language/LanguageValue.class.php');
require_once('application/model/value/user/UserLevelValue.class.php');
require_once('application/model/value/system/PermissionValue.class.php');

// batch
require_once('modules/model/value/batch/InvitationMessageTypeValue.class.php');

// assessmentInvitation
require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');
require_once('modules/model/value/assessmentInvitation/AssessmentInvitationStatusValue.class.php');
require_once('modules/model/value/assessmentInvitation/AssessmentInvitationTypeValue.class.php');

// library
require_once('modules/model/value/library/competence/CategoryValue.class.php');
require_once('modules/model/value/library/competence/ScaleValue.class.php');
require_once('modules/model/value/library/competence/ScoreValue.class.php');
require_once('modules/model/value/library/competence/NormValue.class.php');

// employee
require_once('modules/model/value/employee/competence/ScoreStatusValue.class.php');
require_once('modules/model/value/employee/competence/AssessmentEvaluationStatusValue.class.php');
require_once('modules/model/value/employee/attachment/EmployeeAttachmentTypeValue.class.php');
require_once('modules/model/value/employee/pdpAction/PdpActionCompletedStatusValue.class.php');
require_once('modules/model/value/assessmentProcess/AssessmentProcessEvaluationRequestValue.class.php');
require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');



// alerts.is_done
define('ALERT_OPEN',      0);
define('ALERT_DONE',      1);
define('ALERT_CANCELLED', 2);

// alerts.is_level
define('ALERT_PDPACTION',          1);
define('ALERT_PDPACTIONTASK',      2);
define('ALERT_PDPACTION_EMPLOYEE', 3);
//define('ALERT_PDPACTIONTASK_EMPLOYEE', 4);

// assessment_question.active
define('ASSESSMENT_QUESTION_IS_ACTIVE',  1);
define('ASSESSMENT_QUESTION_IS_DELETED', 2);

// email_cluster.ID_EC
define('ID_EC_INTERNAL', 1);
define('ID_EC_EXTERNAL', 2);

// employees.rating
define('RATING_DICTIONARY',       1);
define('RATING_FUNCTION_PROFILE', 2);

// employees.is_inactive
define('EMPLOYEE_IS_ACTIVE',   0);
define('EMPLOYEE_IS_DISABLED', 1);

// employees.sex
define('GENDER_MALE',   'Male');
define('GENDER_FEMALE', 'Female');

// employees_pdp_actions.is_completed
//define('PDP_ACTION_NOT_COMPLETED', 0);
//define('PDP_ACTION_COMPLETED',     1);
//define('PDP_ACTION_CANCELLED',     2); // TODO: verder implementeren

// employees_pdp_actions.use_action_owner
define('PDP_ACTION_OWNER_USER',     0);
define('PDP_ACTION_OWNER_EMPLOYEE', 1);

define('PDP_ACTION_FROM_LIBRARY',   0);
define('PDP_ACTION_USER_DEFINED',   1);

define('PDP_ACTION_LIBRARY_SYSTEM',     0);
define('PDP_ACTION_LIBRARY_CUSTOMER',   1);

define('PDP_ACTION_LIBRARY_CLUSTER_SYSTEM',     0);
define('PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER',   1);

// employees_pdp_tasks.is_boss
define('EMPLOYEE_IS_EMPLOYEE', 0);
define('EMPLOYEE_IS_MANAGER',  1);

// employees_pdp_tasks.is_completed
define('PDP_TASK_NOT_COMPLETED', 0);
define('PDP_TASK_COMPLETED',     1);

// function_points.key_com
define('FUNCTION_NOT_KEY_COMPETENCE', 0);
define('FUNCTION_IS_KEY_COMPETENCE',  1);

// function_points.weight_factor
define('DEFAULT_FUNCTION_WEIGHT', 2);

// knowledge_skills_points.is_cluster_main
define('COMPETENCE_CLUSTER_IS_NORMAL', 0);
define('COMPETENCE_CLUSTER_IS_MAIN', 1);

// knowledge_skills_points.is_na_allowed
define('COMPETENCE_IS_REQUIRED', 0);
define('COMPETENCE_IS_OPTIONAL', 1);

// module_access.is_active
define('MODULE_ACCESS_SETTING_DISABLED', 0);
define('MODULE_ACCESS_SETTING_ACTIVE',   1);

// themes.ID_T
define('THEME_DEFAULT_ID', 0); // reset value
define('THEME_ORANGE_ID',  1);
define('THEME_BLUE_ID',    6);
define('THEME_GREEN_ID',   7);
define('THEME_PURPLE_ID',  8);
define('THEME_YELLOW_ID',  9);

define('CSS_DEFAULT', 'default');
define('CSS_ORANGE',  'orange');
define('CSS_BLUE',    'blue');
define('CSS_GREEN',   'green');
define('CSS_PURPLE',  'purple');
define('CSS_YELLOW',  'yellow');

// user_departments.permission
define('NO_ACCESS_DEPARTMENT', 0);
define('ALLOW_ACCESS_DEPARTMENT', 1);

// users.allow_access_all_departments
define('ONLY_FROM_USER_DEPARTMENTS',    0);
define('ALWAYS_ACCESS_ALL_DEPARTMENTS', 1);

// users.isprimary
define('USER_NORMAL', 0);
define('USER_PRIMARY_ADMIN', 1);

// users.is_inactive
define('USER_IS_ACTIVE',   0);
define('USER_IS_DISABLED', 1);


// xajax_debug.debug_on
define('XAJAX_DEBUG_ON_VALUE_DISABLED' , 0);
define('XAJAX_DEBUG_ON_VALUE_ENABLED'  , 1);

// Sysadmin id
define('SYS_ADMIN_USER_ID', 1);

?>
