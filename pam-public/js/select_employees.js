function selectEmployees_control(option, trigger_source, showAdditionalProfiles, a_formValues) {

    if (xajax.$('SBdepartment') != null) {
        xajax.$('SBdepartment').selectedIndex = -1;
        xajax.$('SBdepartment').value=0;
        xajax.$('SBdepartment').disabled=true;
        xajax.$('SBdepartment').className = 'disabled';
        xajax.$('SBdepartment').onchange = '';
    }

    if (xajax.$('SBfunction') != null) {
        xajax.$('SBfunction').selectedIndex = -1;
        xajax.$('SBfunction').value=0;
        xajax.$('SBfunction').disabled=true;
        xajax.$('SBfunction').className = 'disabled';
        xajax.$('SBfunction').onchange = '';
    }

    if (xajax.$('SBbosses') != null) {
        xajax.$('SBbosses').selectedIndex = -1;
        xajax.$('SBbosses').value=0;
        xajax.$('SBbosses').disabled=true;
        xajax.$('SBbosses').className = 'disabled';
        xajax.$('SBbosses').onchange = '';
    }

    if (xajax.$('SBcross') != null) {
        xajax.$('SBcross').selectedIndex = -1;
        xajax.$('SBcross').value=0;
        xajax.$('SBcross').disabled=true;
        xajax.$('SBcross').className = 'disabled';
        xajax.$('SBcross').onchange = '';
    }

    if (xajax.$('selempsearchtext') != null) {
        xajax.$('selempsearchtext').disabled=true;
        xajax.$('selempsearchtext').value = '';
        xajax.$('selempsearchtext').className = 'disabled';
    }

    xajax_moduleSelectEmployees_control(option, trigger_source, showAdditionalProfiles, a_formValues);
    return false;
}

function empSearchEmployee(srcElement)
{
    xajax_moduleSelectEmployees_control(0, 1, 0, xajax.getFormValues(srcElement.form.id));
    return false;
}