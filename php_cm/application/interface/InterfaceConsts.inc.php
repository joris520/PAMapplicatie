<?php

require_once('application/library/applicationConsts.inc.php');

define('PROCESS_BUTTON', 'submitButton'); // letop: 'process_button' zit wel als tekst in de javascripts
define('BACK_BUTTON',    'back_button');
define('CANCEL_BUTTON',  'cancel_button');
define('PRINT_BUTTON',   'print_button');

define('APPLICATION_MENU_PANEL',    'application_menu_panel');
define('MODULE_MENU_PANEL',         'modules_menu_panel');
define('MODULE_MAIN_PANEL',         'module_main_panel');

define('MASTER_SCROLL_CONTENT', 'master_scroll_content');
define('FORM_DIALOG',           'form_dialog'); // letop: ook in dialogs.js
define('DIALOG_MESSAGE',        'dialog_message');  // letop: ook in dialogs.js


define('MESSAGE_INFO',    'info');
define('MESSAGE_SUCCESS', 'success');
define('MESSAGE_WARNING', 'warning');
define('MESSAGE_ERROR',   'error');


define('POPUP_DEFAULT', 'default');
define('POPUP_INFO',    'info');
define('POPUP_ERROR',   'error');
define('POPUP_EDIT',    'edit');
define('POPUP_ADD',     'add');
define('POPUP_REMOVE',  'remove');

define('POPUP_DEFAULT_STYLE',   '2px solid #aaa');
define('POPUP_INFO_STYLE',      '3px solid ' . COLOUR_MESSAGE_INFO);    // TODO: theme style
define('POPUP_EDIT_STYLE',      '2px solid ' . COLOUR_MESSAGE_INFO);
define('POPUP_ADD_STYLE',       '2px solid ' . COLOUR_MESSAGE_INFO);
define('POPUP_WARNING_STYLE',   '4px solid ' . COLOUR_MESSAGE_WARNING);
define('POPUP_ERROR_STYLE',     '4px solid ' . COLOUR_MESSAGE_ERROR);

define('MASTER_TITLE',          'master_title');
define('MASTER_HEADER_BUTTONS', 'master_buttons');
define('MASTER_SEARCH',         'master_search');
define('MASTER_SEARCH_LIMIT',   'master_search_limit');
define('MASTER_SCROLL_CONTENT', 'master_scroll_content');

define('TOP_NAVIGATION_CONTENT',    'top_nav_content');
define('TAB_NAVIGATION_CONTENT',    'tab_nav_content');
define('DETAIL_NAVIGATION_CONTENT', 'detail_nav_content');
define('DETAIL_CONTENT',            'detail_content');

define('ORGANISATION_CONTENT',      'organisation-content');

define('EMPLOYEE_CONTENT',                   'empPrint');
define('EMPLOYEE_TAB_NAV_TOP',               'top_nav_btn');
define('EMPLOYEE_TAB_NAV',                   'tabNav');
define('EMPLOYEE_TARGET_CONTENT',            'targetPeriodID');
define('EMPLOYEE_TARGET_EVALUATION_CONTENT', 'employee_target_evaluation_content_');
define('EMPLOYEE_TARGET_STATUS_INLINE',      'target_status_inline_');

?>
