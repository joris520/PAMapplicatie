<?php
/*
 * Ter voorkoming van magic numbers in de code
 */

require_once('application/model/value/language/LanguageValue.class.php');

// form new, copy of edit
define('FORM_MODE_NEW',  1);
define('FORM_MODE_COPY', 2);
define('FORM_MODE_EDIT', 3);
define('FORM_MODE_NEW_WIZARD', 4);


// interface icon files
define('ICON_INTERFACE_PATH', 'images/icons/interface/');
define('ICON_ALL',          ICON_INTERFACE_PATH . 'zoom_out_16.png');
define('ICON_ADD',          ICON_INTERFACE_PATH . 'add_14.png');
define('ICON_CALENDAR',     ICON_INTERFACE_PATH . 'calendar_16.png');
define('ICON_CANCEL',       ICON_INTERFACE_PATH . 'cancel_14.png');
define('ICON_DELETE',       ICON_INTERFACE_PATH . 'remove_14.png');
define('ICON_DETAILS',      ICON_INTERFACE_PATH . 'zoom_in_16.png');
define('ICON_EDIT',         ICON_INTERFACE_PATH . 'edit_13.png');
define('ICON_HISTORY',      ICON_INTERFACE_PATH . 'copy_v2_16.png');
define('ICON_ERASE',        ICON_INTERFACE_PATH . 'delete_14_orange.png');
//define('ICON_INFO',         ICON_INTERFACE_PATH . 'information_14.png');
define('ICON_INFO',         ICON_INTERFACE_PATH . 'information_14_grey.png');
define('ICON_INVITE',       ICON_INTERFACE_PATH . 'send_16.png');
define('ICON_NOADD',        ICON_INTERFACE_PATH . 'noadd_14.png');
define('ICON_NOEDIT',       ICON_INTERFACE_PATH . 'noedit_13.png');
define('ICON_PDF',          ICON_INTERFACE_PATH . 'pdf_32.png');
define('ICON_PHOTO',        ICON_INTERFACE_PATH . 'user_16.png');
define('ICON_PRINT',        ICON_INTERFACE_PATH . 'print_16.png');
define('ICON_SAVE',         ICON_INTERFACE_PATH . 'save_14.png');
define('ICON_SEARCH',       ICON_INTERFACE_PATH . 'search_14.png');
define('ICON_SETTINGS',     ICON_INTERFACE_PATH . 'settings_16.png');
define('ICON_UNDO',         ICON_INTERFACE_PATH . 'undo_14.png');
define('ICON_UPLOAD',       ICON_INTERFACE_PATH . 'upload_16.png');
define('ICON_XLS',          ICON_INTERFACE_PATH . 'xls_32.png');
define('ICON_UP',           ICON_INTERFACE_PATH . 'up_10.png');
define('ICON_DOWN',         ICON_INTERFACE_PATH . 'down_10.png');
define('ICON_WEBSITE',      ICON_INTERFACE_PATH . 'globe_16.png');
define('ICON_COMMENTS',     ICON_INTERFACE_PATH . 'comment_dots_blue.png');
define('ICON_COMMENT',      ICON_INTERFACE_PATH . 'comment_dots_grey.png');
define('ICON_COMMENT_EDIT', ICON_INTERFACE_PATH . 'comment_dots_grey_edit.png');
//define('ICON_COMMENTS',     ICON_INTERFACE_PATH . 'comment-dots.png');

// process icon files
define('ICON_WORKFLOW_PATH', 'images/icons/workflow/');
define('ICON_EMPLOYEE_ASSESSMENT_COMPLETED',                ICON_WORKFLOW_PATH  . 'employee_assessment_green.png');
define('ICON_EMPLOYEE_ASSESSMENT_COMPLETED_DELETED',        ICON_WORKFLOW_PATH  . 'employee_assessment_green_deleted.png');
define('ICON_EMPLOYEE_ASSESSMENT_NOT_COMPLETED',            ICON_WORKFLOW_PATH  . 'employee_assessment_orange.png');
define('ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED',              ICON_WORKFLOW_PATH  . 'employee_assessment_transparent.png');
define('ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED_THIS_PERIOD',  ICON_WORKFLOW_PATH  . 'employee_assessment_grey.png');
// functioneringsgesprek
define('ICON_EMPLOYEE_CONVERSATION_PLANNED_10',             ICON_WORKFLOW_PATH  . 'employee_conversation_orange_10.png');
define('ICON_EMPLOYEE_CONVERSATION_COMPLETED_10',           ICON_WORKFLOW_PATH  . 'employee_conversation_green_10.png');
define('ICON_EMPLOYEE_CONVERSATION_CANCELLED_10',           ICON_WORKFLOW_PATH  . 'employee_conversation_grey_10.png');
define('ICON_EMPLOYEE_CONVERSATION_NOT_INVITED_10',         ICON_WORKFLOW_PATH  . 'employee_conversation_grey_10.png');

define('ICON_EMPLOYEE_CONVERSATION_PLANNED',                ICON_WORKFLOW_PATH  . 'employee_conversation_orange.png');
define('ICON_EMPLOYEE_CONVERSATION_COMPLETED',              ICON_WORKFLOW_PATH  . 'employee_conversation_green.png');
define('ICON_EMPLOYEE_CONVERSATION_CANCELLED',              ICON_WORKFLOW_PATH  . 'employee_conversation_grey.png');
define('ICON_EMPLOYEE_CONVERSATION_NOT_INVITED',            ICON_WORKFLOW_PATH  . 'employee_conversation_grey.png');
define('ICON_EMPLOYEE_CONVERSATION_LOS',                    ICON_WORKFLOW_PATH  . 'employee_conversation_green.png');

define('ICON_EMPLOYEE_CONVERSATION_PLANNED_WHITE',          ICON_WORKFLOW_PATH  . 'employee_conversation_red_white.png');
define('ICON_EMPLOYEE_CONVERSATION_COMPLETED_WHITE',        ICON_WORKFLOW_PATH  . 'employee_conversation_green_white.png');
define('ICON_EMPLOYEE_CONVERSATION_NOT_INVITED_WHITE',      ICON_WORKFLOW_PATH  . 'employee_conversation_grey_white.png');

//define('NO_HELP_ID', null);
define('NO_BUTTON_CLASS', null);
define('NO_ICON',         null);
define('FORCE_USE_ICON',  true);

// upload en images spul
define('PHOTO_INTERFACE_PATH', 'images/');

define('DEFAULT_PHOTO_WIDTH',   165);
define('DEFAULT_PHOTO_HEIGHT',  190);

define('EMPLOYEE_GENERIC_FEMALE_THUMB',     PHOTO_INTERFACE_PATH  . 'generic-thumbnail-female.png');
define('EMPLOYEE_GENERIC_MALE_THUMB',       PHOTO_INTERFACE_PATH  . 'generic-thumbnail-male.png');
define('EMPLOYEE_GENERIC_UNKNOWN_THUMB',    PHOTO_INTERFACE_PATH  . 'generic-thumbnail-unknown.png');
define('THUMB_SCALE_FACTOR',            3);
define('DEFAULT_GENERIC_FEMALE_THUMB_WIDTH',   DEFAULT_PHOTO_WIDTH/THUMB_SCALE_FACTOR);
define('DEFAULT_GENERIC_FEMALE_THUMB_HEIGHT',  DEFAULT_PHOTO_HEIGHT/THUMB_SCALE_FACTOR);

define('MAX_LOGO_BYTESIZE',         1024 * 250); // the max. size for uploading logo, 250 k)
define('MAX_PHOTO_BYTESIZE',        1024 * 250); // the max. size for uploading photo, 250 k)
define('MAX_ATTACHMENT_BYTESIZE',   1024 * 1024 * 2); // the max. size for uploading attachment, 2 M)
define('MAX_DOCUMENTNAME_LENGTH',   100);

define('DEFAULT_LOGO_WIDTH',    180);
define('DEFAULT_LOGO_HEIGHT',   80);
define('MAX_LOGO_WIDTH',    320);
define('MAX_LOGO_HEIGHT',   80);

define('PDF_DEFAULT_LOGO_FACTOR',  5); // hbd: pam pdf logo op 5 zodat het default logo niet te groot wordt;
define('PDF_CUSTOMER_LOGO_FACTOR', 5);

//define('CUSTOMER_LOGO_NAME',    'customer_logo.jpg');
define('APPLICATION_DEFAULT_LOGO_FILE_URL', 'images/logo/default_logo.jpg');

define('GET_FILE_WITH_PATH',    1);
define('GET_FILE_WITH_URL',     2);

// bijhouden in sessie
define('SESSION_USER_ID',       'user_id');
define('SESSION_LOG_USER_NAME', 'log_name');
define('SESSION_CUSTOMER_ID',   'customer_id');
define('SESSION_USER_MODE',     'user_mode');

define('SESSION_USER_MODE_NOT_LOGGED_IN',           0);
define('SESSION_USER_MODE_LOGGED_IN',               2);

define('LOGIN_STATUS_NO_ERROR',    0);
define('LOGIN_STATUS_INVALID',     1);

// Language id waarden
define('DEFAULT_LANG_ID', LanguageValue::LANG_ID_NL);

// message kleuren (uit twitter bootstrap)
define('COLOUR_MESSAGE_SUCCESS',   '#468847');
define('COLOUR_MESSAGE_INFO',      '#3A87AD');
define('COLOUR_MESSAGE_WARNING',   '#F89406');
define('COLOUR_MESSAGE_ERROR',     '#B94A48');

// schaal normering kleuren
define('COLOUR_RED',        '#dd0000');
define('COLOUR_DARK_BLUE',  '#003ae6');
define('COLOUR_LIGHT_BLUE', '#96beff');
define('COLOUR_GREEN',      '#22aa22');
define('COLOUR_YELLOW',     '#fcf900');
define('COLOUR_ORANGE',     '#e2871b');
//
define('COLOUR_WHITE',       '#ffffff');
define('COLOUR_LIGHT_GRAY',  '#dddddd');
define('COLOUR_MEDIUM_GRAY', '#bbbbbb');
define('COLOUR_GRAY',        '#999999');
define('COLOUR_DARK_GRAY',   '#777777');
define('COLOUR_BLACK',       '#000000');

// directories aangemaakt voor
define('DIRECTORY_ACCESS_SETTINGS', 0775);
define('DIRECTORY_TEMP',            'temp/');

define('MODULE_SUBSET_LOGIN',                   'module_subset_login');
define('MODULE_SUBSET_THREESIXTY',              'module_subset_threesixty');
define('MODULE_SUBSET_APPLICATION',             'module_subset_application');
define('MODULE_SUBSET_UPLOAD_PHOTO',            'module_subset_upload_photo');
define('MODULE_SUBSET_UPLOAD_LOGO',             'module_subset_upload_logo');
define('MODULE_SUBSET_UPLOAD_ATTACHMENT',       'module_subset_upload_attachment');
define('MODULE_SUBSET_CONFIRM_NOTIFICATION',    'module_subset_confirm_notification');
define('MODULE_SUBSET_DOWNLOAD_DB',             'module_subset_download_db');
define('MODULE_SUBSET_CUSTOMERS',               'module_subset_customers');

// employee name formatting
define('EMPLOYEENAME_FORMAT_LASTNAME_FIRST',  1);
define('EMPLOYEENAME_FORMAT_FIRSTNAME_FIRST', 2);

define('PDP_ACTION_INDICATOR_FROM_LIBRARY' , '');
define('PDP_ACTION_INDICATOR_USER_DEFINED' , '*');

define('SWITCHED_TO_USER_LEVEL_EMPLOYEE', 4);

?>
