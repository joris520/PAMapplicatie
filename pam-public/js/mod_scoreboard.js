function calculateEmpScore()
{
	xajax.$('subCalcBtn').disabled=true;
	xajax_moduleScoreboard_calcProcess(xajax.getFormValues("scoreboardForm"), 0);
	return false;
}


