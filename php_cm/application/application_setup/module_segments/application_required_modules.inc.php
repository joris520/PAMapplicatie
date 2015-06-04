<?php

require_once('modules/logout.php');
require_once('application/public/navigation_xajax.php');
require_once('application/public/application_xajax.php');
require_once('modules/to_refactor/organisation_batch.php');
require_once('modules/to_refactor/organisation_reports.php');
include_once('modules/competences_deprecated.php');
include_once('modules/functions.php');
include_once('modules/functions_benchmarking.php');

include_once('modules/employees_deprecated.php');
include_once('modules/employees_prints.php');
include_once('modules/pdp_action_library.php');
include_once('modules/pdp_task_library.php');
include_once('modules/pdp_task_owner.php');
include_once('modules/emails.php');
include_once('modules/threesixty.php');

include_once('modules/performance_grid.php');
/* SCORE Response Module */
include_once('modules/scoreboard_interface.php');
include_once('modules/scoreboard_individual.php');
include_once('modules/scoreboard_team.php');

/* HISTORY Response Module */
include_once('modules/history.php');

/* PDP Response Module */
include_once('modules/pdp_todo_list.php');

/* SYSTEM Response Module */
include_once('modules/users.php');
include_once('modules/system_setting.php');
include_once('modules/themes.php');
include_once('modules/scales.php');

/* HELP Response Module */
include_once('modules/PAM_info.php');
include_once('modules/technical_manual.php');
include_once('modules/user_manual.php');

include_once('modules/level_authorization.php');

// wordt op verschillende plekken gebruikt ...
include_once('modules/interface/components/select/SelectEmployees.class.php');


include_once('modules/model/service/to_refactor/PersonDataService.class.php');

require_once('application/interface/InterfaceXajax.class.php');
require_once('application/interface/InterfaceBuilder.class.php');

// nieuwe stijl public xajax functions
// library
require_once('modules/public/library/competence_xajax.php');
require_once('modules/public/library/assessmentCycle_xajax.php');
require_once('modules/public/library/question_xajax.php');
require_once('modules/public/library/documentCluster_xajax.php');
require_once('modules/public/library/pdpAction_xajax.php');

// list
require_once('modules/public/list/employeeList_xajax.php');

// assessment process
require_once('modules/public/assessmentProcess/assessmentProcess_xajax.php');

// employee
require_once('modules/public/employee/employeeTab_xajax.php');
require_once('modules/public/employee/employeeProfile_xajax.php');
require_once('modules/public/employee/employeeDocument_xajax.php');
require_once('modules/public/employee/employeeCompetence_xajax.php');
require_once('modules/public/employee/employeePdpAction_xajax.php');
require_once('modules/public/employee/employeeTarget_xajax.php');
require_once('modules/public/employee/employeeFinalResult_xajax.php');
require_once('modules/public/employee/employeeTraining_xajax.php');
require_once('modules/public/employee/employeeAssessmentInvitation_xajax.php');
require_once('modules/public/employee/employeePrint_xajax.php');

// organisation
require_once('modules/public/organisation/organisation_xajax.php');
require_once('modules/public/organisation/organisationInfo_xajax.php');
require_once('modules/public/organisation/department_xajax.php');

// zelfevaluatie
require_once('modules/public/selfAssessment/selfAssessment_xajax.php');

// dashboard
require_once('modules/public/dashboard/dashboard_xajax.php');

// settings
require_once('modules/public/settings/standardDate_xajax.php');

// reports
require_once('modules/public/report/managerReport_xajax.php');
require_once('modules/public/report/talentSelector_xajax.php');
require_once('modules/public/report/selfAssessmentReport_xajax.php');
require_once('modules/public/report/assessmentProcessReport_xajax.php');
require_once('modules/public/report/pdpActionReport_xajax.php');
require_once('modules/public/report/targetReport_xajax.php');
require_once('modules/public/report/finalResultReport_xajax.php');
require_once('modules/public/report/trainingReport_xajax.php');
require_once('modules/public/report/commonReport_xajax.php');

// batch
require_once('modules/public/batch/batch_xajax.php');


?>