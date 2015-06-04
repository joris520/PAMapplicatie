function reportSelfassessmentFormExecute()
{
	xajax.$('reportsFormBtn').disabled=true;
	xajax_moduleOrganisation_processSelfassessmentReportsForm(xajax.getFormValues("selfassessmentReportForm"));
	return false;
}
