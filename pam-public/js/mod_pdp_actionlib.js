function clusterPer()
{
    xajax.$('cluster').disabled=false;
    return false;
}

function clusterAll()
{
    xajax.$('cluster').disabled=true;
    return false;
}

function print_actionlib()
{
    xajax_modulePDPActionLibrary_processPrintPDPActions(xajax.getFormValues('clusterPrintForm'));
    return false;
}
