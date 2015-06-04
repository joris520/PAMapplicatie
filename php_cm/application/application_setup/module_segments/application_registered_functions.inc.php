<?php

$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processSafeForm');
$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processPopupSafeForm');
$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processFilterSafeForm');
$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processActionSafeForm');

// {{ navigations functions
$xajax->register(XAJAX_FUNCTION, 'public_navigation_startApplication');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_employees');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_dashboard');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_selfAssessment');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_organisation');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_reports');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_library');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_settings');
$xajax->register(XAJAX_FUNCTION, 'public_navigation_applicationMenu_help');
if (APPLICATION_REFERENCE_DATE_EDITOR_ALLOWED) {
    $xajax->register(XAJAX_FUNCTION, 'public_modifyCurrentDate');
}

$xajax->register(XAJAX_FUNCTION, 'public_application_changePassword');
$xajax->register(XAJAX_FUNCTION, 'public_application_toggleUserLevel');


// }}
// {{ modules functions
//$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence');
$xajax->register(XAJAX_FUNCTION, 'moduleFunctions');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwner');
$xajax->register(XAJAX_FUNCTION, 'modulePDPToDoList_menu');
$xajax->register(XAJAX_FUNCTION, 'modulePDPToDoList');
$xajax->register(XAJAX_FUNCTION, 'moduleUsers');
$xajax->register(XAJAX_FUNCTION, 'moduleSystemSetting');
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_scales');
$xajax->register(XAJAX_FUNCTION, 'modulePAMInfo');
$xajax->register(XAJAX_FUNCTION, 'moduleTechnicalManual');
$xajax->register(XAJAX_FUNCTION, 'moduleUserManual');

// MOD ORGANISATION

$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation_pdpActionsBatchForm');
$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation_pdpActionsAddBatch');
$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation_attachmentBatchForm');
$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation_selfassessmentReportsForm');
$xajax->register(XAJAX_FUNCTION, 'moduleOrganisation_processSelfassessmentReportsForm');


// }}
// {{ MOD COMPETENCE
// cluster
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_addCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'competences_processSafeForm_AddCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_editCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'competences_processSafeForm_editCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_deleteCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_executeDeleteCluster_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_showCluster_deprecated');
// competence
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_addCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'competences_processSafeForm_addCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_editCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'competences_processSafeForm_editCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_deleteCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_executeDeleteCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_showCompetenceDetail_deprecated');
// misc
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_selectControlScaleAddmode_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_selectControlScaleEditmode_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_copyCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_displayClusterByCategory_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleCompetence_clickCompetenceHide_deprecated');
// }}
// {{ MOD FUNCTION

$xajax->register(XAJAX_FUNCTION, 'moduleFunction_executePrintFunctions_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_addFunction_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_displayFunctionCompetence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_executeAddForm');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_editFunctionComptence_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_deleteFunction_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_executeDeleteFunction');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_benchmarkingOptions_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_showScaleDetails_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_hideScaleDetails_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_printJobProfile_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_useExistingProfile_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_showFuncDict');
$xajax->register(XAJAX_FUNCTION, 'moduleFunction_hideFuncDict');
// }}


// }}
// {{ MOD PDP ACTION LIBRARY
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_addPDPAction');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_showAction');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_editAction');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_deletePDPAction');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_executeDeletePDPAction');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_addPDPCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_editPDPCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_showPDPCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_deletePDPCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_executeDeletePDPCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_showPDPActionsInCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_printPDPActions');
$xajax->register(XAJAX_FUNCTION, 'modulePDPActionLibrary_processPrintPDPActions');
// }}
// {{ MOD PDP TASK LIBRARY
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary');

$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary_addPDPtask');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary_displayTask');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary_editTask');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary_deletePDPtask');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskLibrary_executeDeletePDPtask');
$xajax->register(XAJAX_FUNCTION, 'module360_display360Employees');
$xajax->register(XAJAX_FUNCTION, 'module360_searchEmployees');
// }}
// {{ MOD PDP TASK OWNER LIBRARY
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary_addTaskOwner');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary_displayTaskOwner');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary_editTaskOwner');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary_deleteTaskOwner');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwnerLibrary_executeDeleteTaskOwner');
// }}
// {{ MOD EMPLOYEES

$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_startup');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_checkTab_deprecated');

$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_attachments_menu_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_pdpActions_menu_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_360_menu_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_history_menu_deprecated');

$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_addEmployee_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_cancelAddEmployee_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_profileForm_deprecated');

$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_deletePDPActions_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_pdpActionTaskForm_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_deletePDPActionsTask_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executeDeletePDPActionsTask_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleSettings_executeDeleteEmployee');
$xajax->register(XAJAX_FUNCTION, 'moduleSettings_restoreEmployee');
$xajax->register(XAJAX_FUNCTION, 'executePermanentlyDeleteEmployee');
$xajax->register(XAJAX_FUNCTION, 'prefill_pdp_action_deprecated');

//print
$xajax->register(XAJAX_FUNCTION, 'public_dashboard_printEmployeesFullPortfolio_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployeesPrints_printEmployeesFullPortfolio_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployeesPrints_executePrintEmployeesFullPortfolio_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executePrintScore_deprecated');

$xajax->register(XAJAX_FUNCTION, 'modulePerformanceGrid_menu');
$xajax->register(XAJAX_FUNCTION, 'modulePerformanceGrid_displayPerformanceGrid');
$xajax->register(XAJAX_FUNCTION, 'modulePerformanceGrid_printPerformanceGrid');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executePrintPDPAction_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executePrintPDPCost_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executePrintTarget');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_printAttachments_deprecated');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_executePrintAttachments_deprecated');


// {{ MOD EMPLOYEE HISTORY 11/04/08
$xajax->register(XAJAX_FUNCTION, 'moduleHistory');
$xajax->register(XAJAX_FUNCTION, 'moduleHistory_menu');

$xajax->register(XAJAX_FUNCTION, 'moduleHistory_showEmployeeHistory');
$xajax->register(XAJAX_FUNCTION, 'moduleHistory_addEmployeeHistory');
$xajax->register(XAJAX_FUNCTION, 'moduleHistory_showSelectedEmployeeHistory');
$xajax->register(XAJAX_FUNCTION, 'moduleHistory_deleteSelectedEmployeeHistory');

$xajax->register(XAJAX_FUNCTION, 'moduleHistory_showPreviousHistories');


// {{ MOD EMPLOYEE SCOREBOARD 11/07/08
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_menu');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_calc');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_selectEmployee');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_filter_currentFunction');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_filter_otherFunction');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_filter_functionGroup');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_filter_functionGroupDep');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_calcProcess');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_fillFunctionlistForDepartment');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_calcProcess_individual');
$xajax->register(XAJAX_FUNCTION, 'moduleScoreboard_calcProcess_team');

//
// {{ MOD PDP TO DO LIST 12/02/08
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_getValues');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_getTargets');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_print');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_singleEmployee');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_allEmployees');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_taskOwner');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_getSelectValues');
$xajax->register(XAJAX_FUNCTION, 'pdptodolist_setUsers');
//}}
//MOD USERS
$xajax->register(XAJAX_FUNCTION, 'moduleUsers_displayUser');
$xajax->register(XAJAX_FUNCTION, 'moduleUsers_editUser');
$xajax->register(XAJAX_FUNCTION, 'moduleUsers_addUser');
$xajax->register(XAJAX_FUNCTION, 'moduleUsers_deleteUser');
$xajax->register(XAJAX_FUNCTION, 'moduleUsers_executeDeleteUser');
$xajax->register(XAJAX_FUNCTION, 'moduleLevelAuthorisation_displayLevelAuthorization');


$xajax->register(XAJAX_FUNCTION, 'moduleEmails_displayExternalEmailAddresses');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_editExternalEmailAddresses');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_deleteExternalEmailAddresses');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_executeDeleteExternalEmailAddresses');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_displayNotificationMessage');
// logo
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_themeLogo');
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_resetThemeLogo');
// color
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_editThemeColour');
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_resetThemeColour');
// language
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_editThemeLanguage');
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_resetThemeLanguage');

$xajax->register(XAJAX_FUNCTION, 'moduleEmails_showPDPActionsNotificationAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleOptions_showEmployeesArchive');

//MOD PRINTs
$xajax->register(XAJAX_FUNCTION, 'moduleEmployeesPrints_printEmployeesFullPortfolio');
$xajax->register(XAJAX_FUNCTION, 'moduleEmployeesPrints_printFullPortfolio');

$xajax->register(XAJAX_FUNCTION, 'moduleFunctions_benchmarkingValidate_deprecated');

$xajax->register(XAJAX_FUNCTION, 'modulePDPTodoList_allActions');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTodoList_actionOwner');

$xajax->register(XAJAX_FUNCTION, 'moduleLevelAuth_displayAccess');

$xajax->register(XAJAX_FUNCTION, 'moduleFAQ');

$xajax->register(XAJAX_FUNCTION, 'module360_display360Degree');
$xajax->register(XAJAX_FUNCTION, 'moduleHistory_searchHistoryE');
$xajax->register(XAJAX_FUNCTION, 'moduleUtils_showLastModifiedInfo');
$xajax->register(XAJAX_FUNCTION, 'moduleUtils_showLastModifiedInfo2');

$xajax->register(XAJAX_FUNCTION, 'module360_executePrintSingleEmployeeThreesixty');
$xajax->register(XAJAX_FUNCTION, 'module360_executePrintThreesixty');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_printAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_printActionAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_printTaskAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_printActionAndTaskAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_processPrintAlerts');
$xajax->register(XAJAX_FUNCTION, 'moduleEmails_notification360Message');

$xajax->register(XAJAX_FUNCTION, 'moduleEmployees_clearNotificationDate_deprecated');

$xajax->register(XAJAX_FUNCTION, 'module360_deleteEmployee360');
$xajax->register(XAJAX_FUNCTION, 'module360_executeDeleteEmployee360');

$xajax->register(XAJAX_FUNCTION, 'module360_delete360SingleEvaluation');
$xajax->register(XAJAX_FUNCTION, 'module360_employee_delete360SingleEvaluation');
$xajax->register(XAJAX_FUNCTION, 'module360_executeDelete360SingleEvaluation');


// selectEmployees component
$xajax->register(XAJAX_FUNCTION, 'moduleSelectEmployees_control');
$xajax->register(XAJAX_FUNCTION, 'modulePersonData_selectEmailCluster');
$xajax->register(XAJAX_FUNCTION, 'modulePDPTaskOwner_searchPDPTaskOwner');



// logout
$xajax->register(XAJAX_FUNCTION, 'moduleLogin_logOut');



////////////////////////////////////////////////////////
// nieuwe stijl
////////////////////////////////////////////////////////
// LIBRARY
// questions
$xajax->register(XAJAX_FUNCTION, 'public_library__displayQuestions');
$xajax->register(XAJAX_FUNCTION, 'public_library__addQuestion');
$xajax->register(XAJAX_FUNCTION, 'public_library__editQuestion');
$xajax->register(XAJAX_FUNCTION, 'public_library__removeQuestion');

// evaluatie periode
$xajax->register(XAJAX_FUNCTION, 'public_library__displayAssessmentCycles');
$xajax->register(XAJAX_FUNCTION, 'public_library__addAssessmentCycle');
$xajax->register(XAJAX_FUNCTION, 'public_library__editAssessmentCycle');
$xajax->register(XAJAX_FUNCTION, 'public_library__removeAssessmentCycle');

// competences
$xajax->register(XAJAX_FUNCTION, 'public_library__showCompetenceDetail');
$xajax->register(XAJAX_FUNCTION, 'public_library__hideCompetenceDetail');

// document clusters
$xajax->register(XAJAX_FUNCTION, 'public_library__displayDocumentClusters');
$xajax->register(XAJAX_FUNCTION, 'public_library__addDocumentCluster');
$xajax->register(XAJAX_FUNCTION, 'public_library__editDocumentCluster');
$xajax->register(XAJAX_FUNCTION, 'public_library__removeDocumentCluster');

// PDP actions
$xajax->register(XAJAX_FUNCTION, 'public_library__displayPdpActions');
$xajax->register(XAJAX_FUNCTION, 'public_library__printPdpActions');
$xajax->register(XAJAX_FUNCTION, 'public_library__addPdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_library__editPdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_library__removePdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_library__detailPdpActionEmployees');
$xajax->register(XAJAX_FUNCTION, 'public_library__editUserDefinedEmployeePdpAction');

$xajax->register(XAJAX_FUNCTION, 'public_library__editPdpActionCluster');
$xajax->register(XAJAX_FUNCTION, 'public_library__removePdpActionCluster');


// EMPLOYEE
// tab
$xajax->register(XAJAX_FUNCTION, 'public_employee__displayTab');

//list
$xajax->register(XAJAX_FUNCTION, 'public_employeeList__addEmployee');
$xajax->register(XAJAX_FUNCTION, 'public_employeeList__archiveEmployee');
$xajax->register(XAJAX_FUNCTION, 'public_employeeList__toggleFilterVisibility');

// assessment process
$xajax->register(XAJAX_FUNCTION, 'public_assessmentProcess__toggleEvaluationInvited');


// profile
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__displayPage');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__editPersonal');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__removePhoto');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__uploadPhoto');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__editOrganisation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__editInformation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeProfile__addUser');

// scores
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayPage');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editBulkScores');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editClusterScores');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editScoreCallback');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayHistoryScore');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editAssessmentQuestionsAnswer');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayHistoryQuestionAnswer');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editAssessment');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__addAssessment'); // de edit voor als er nog geen data is.
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayHistoryAssessment');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__resendSelfAssessmentInvitation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editAssessmentEvaluation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__addAssessmentEvaluation'); // de edit voor als er nog geen data is.
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__cancelEditAssessmentEvaluation'); // de cancel, nodig als er al een document upload is
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__removeAssessmentEvaluation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayHistoryAssessmentEvaluation');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__editJobProfile');
$xajax->register(XAJAX_FUNCTION, 'public_employeeCompetence__displayHistoryJobProfile');

// documents
//
$xajax->register(XAJAX_FUNCTION, 'public_employeeDocument__displayPage');
$xajax->register(XAJAX_FUNCTION, 'public_employeeDocument__uploadDocument');
$xajax->register(XAJAX_FUNCTION, 'public_employeeDocument__cancelUploadDocument');
$xajax->register(XAJAX_FUNCTION, 'public_employeeDocument__removeDocument');
$xajax->register(XAJAX_FUNCTION, 'public_employeeDocument__editDocumentInfo');

// PDP actions
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__displayPage');
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__addPdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__editPdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__removePdpAction');
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__togglePdpActionLibraryVisibility');
$xajax->register(XAJAX_FUNCTION, 'public_employeePdpAction__toggleCompetencesVisibility');




// print
$xajax->register(XAJAX_FUNCTION, 'public_employeePrint__displayPrintOptions');

// opleidingen
$xajax->register(XAJAX_FUNCTION, 'public_employeeTraining__displayTraining');

// eindbeoordeling
$xajax->register(XAJAX_FUNCTION, 'public_employeeFinalResult__displayFinalResult');
$xajax->register(XAJAX_FUNCTION, 'public_employeeFinalResult__addFinalResult');
$xajax->register(XAJAX_FUNCTION, 'public_employeeFinalResult__editFinalResult');
$xajax->register(XAJAX_FUNCTION, 'public_employeeFinalResult__historyFinalResult');

// targets
$xajax->register(XAJAX_FUNCTION, 'public_employeeTarget__displayEmployeeTargets');
$xajax->register(XAJAX_FUNCTION, 'public_employeeTarget__addEmployeeTarget');
$xajax->register(XAJAX_FUNCTION, 'public_employeeTarget__editEmployeeTarget');
$xajax->register(XAJAX_FUNCTION, 'public_employeeTarget__removeEmployeeTarget');
$xajax->register(XAJAX_FUNCTION, 'public_employeeTarget__historyEmployeeTarget');
// assessment invitations
$xajax->register(XAJAX_FUNCTION, 'public_employeeAssessmentInvitation__displayPage');


// ORGANISATION
$xajax->register(XAJAX_FUNCTION, 'public_organisation__displayTab');
$xajax->register(XAJAX_FUNCTION, 'public_organisationInfo__displayInfo');
$xajax->register(XAJAX_FUNCTION, 'public_organisationInfo__editInfo');


$xajax->register(XAJAX_FUNCTION, 'public_organisation__displayDepartments');
$xajax->register(XAJAX_FUNCTION, 'public_library__displayDepartments');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayDepartments');
$xajax->register(XAJAX_FUNCTION, 'public_organisation__addDepartment');
$xajax->register(XAJAX_FUNCTION, 'public_organisation__editDepartment');
$xajax->register(XAJAX_FUNCTION, 'public_organisation__removeDepartment');
$xajax->register(XAJAX_FUNCTION, 'public_organisation__detailDepartmentEmployees');
$xajax->register(XAJAX_FUNCTION, 'public_organisation__detailDepartmentUsers');


// SETTINGS
$xajax->register(XAJAX_FUNCTION, 'public_settings__displayStandardDate');
$xajax->register(XAJAX_FUNCTION, 'public_settings__editStandardDate');

// REPORTS
$xajax->register(XAJAX_FUNCTION, 'public_organisation__displayManagers');
$xajax->register(XAJAX_FUNCTION, 'public_report__displayManagers');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayManagers');
$xajax->register(XAJAX_FUNCTION, 'public_report__detailManagerDepartments');
$xajax->register(XAJAX_FUNCTION, 'public_report__detailManagerEmployees');
$xajax->register(XAJAX_FUNCTION, 'public_report__displayTalentSelector');
$xajax->register(XAJAX_FUNCTION, 'public_report__displayInvitations');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayInvitations');
$xajax->register(XAJAX_FUNCTION, 'public_report__detailInvitation');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__detailInvitation');
$xajax->register(XAJAX_FUNCTION, 'public_report__displayInvitationDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayInvitationDashboard');
// dashboard invitations
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardInvitationsDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardEmployeeNotCompletedDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardEmployeeCompletedDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardBossNotCompletedDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardBossCompletedDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardFullCompletedDetail');
// dashboard process
$xajax->register(XAJAX_FUNCTION, 'public_report__displayProcessDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayProcessDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessPhase1Detail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessPhase2Detail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessPhase3Detail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessEvaluationNoneDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessEvaluationPlannedDetail');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardProcessEvaluationReadyDetail');
// dashboard Final Results
//$xajax->register(XAJAX_FUNCTION, 'public_report__displayFinalResultDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayFinalResultDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardFinalResultScoreDetail');
//dashboard Training
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayTrainingDashboard');

// dashboard PDP actions
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayPdpActionDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayPdpActionCompletedStatusDetail');

// dashboard Targets
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayTargetDashboard');
$xajax->register(XAJAX_FUNCTION, 'public_dashboard__displayTargetStatusDetail');

// dashboard common
$xajax->register(XAJAX_FUNCTION, 'public_report__selectAssessmentCycle');
$xajax->register(XAJAX_FUNCTION, 'public_report__cancelSelectAssessmentCycle');
$xajax->register(XAJAX_FUNCTION, 'public_report__dashboardEmployeesTotalDetail');




// BATCH
$xajax->register(XAJAX_FUNCTION, 'public_batch_addTarget');
$xajax->register(XAJAX_FUNCTION, 'public_batch_inviteSelfAssessment');
$xajax->register(XAJAX_FUNCTION, 'public_batch_remindSelfAssessment');
// SELFASSESSMENT MENU
$xajax->register(XAJAX_FUNCTION, 'public_selfAssessment__displayTab');


?>