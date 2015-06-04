<?php
global $xajax;

$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processSafeForm');
$xajax->register(XAJAX_FUNCTION, 'moduleApplication_processPopupSafeForm');

$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_deleteCustomer');
$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_executeDeleteCustomer');

$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_account');

$xajax->register(XAJAX_FUNCTION, 'moduleLogin_logOut');

$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_PrivilegesReport');
$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_ConfigurationReport');
$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_utils_exportCustomerLogosAndEmployeePhotosToEnvironment');

$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_displayCustomers');
$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_addCustomer');
$xajax->register(XAJAX_FUNCTION, 'moduleCustomers_editCustomer');

?>
