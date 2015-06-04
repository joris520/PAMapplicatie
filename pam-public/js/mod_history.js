function delEHPD(showEmployeeName)
{
	xajax.$('delbtn').disabled=true;
	xajax_moduleHistory_deleteSelectedEmployeeHistory(xajax.getFormValues("dateForm"), showEmployeeName);
	return false;
}
