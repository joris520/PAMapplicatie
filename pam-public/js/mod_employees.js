

// OLD

function performanceGridPrint(form_name)
{
    xajax_modulePerformanceGrid_printPerformanceGrid(xajax.getFormValues(form_name));
    return false;
}



function empPrintFullProfileExecute()
{
    xajax_moduleEmployeesPrints_executePrintEmployeesFullPortfolio_deprecated(xajax.getFormValues("empPrintForm"));
    return false;
}

//function empPrintScoreExecute()
//{
//    xajax_moduleEmployees_executePrintScore_deprecated(xajax.getFormValues("empPrintForm"));
//    return false;
//}


function moveJobProfile(action) {

    // content of hidden ID_F's that are actually POSTed in the form (and processed afterwards)
    var selected_ID_Fs = document.getElementById("selectedID_Fs");
    // array version for processing in this function
    var selected_ID_FsArray = selected_ID_Fs.value.split(",");

    // sometimes split results in empty first element
    if (selected_ID_FsArray[0] == "")
        selected_ID_FsArray.shift();

    // dropdown select for selecting main job profile
    //var main_ID_F_select = document.getElementById("mainID_F");
    var main_ID_F_select = document.getElementById("ID_FID");

    // source select
    var sF = document.getElementById(((action == "remove")?"destinationSelect":"sourceSelect"));
    // destination select
    var dF = document.getElementById(((action == "remove")?"sourceSelect":"destinationSelect"));

    // wrong item selected or incorrect call of function
    if(sF.length == 0 || sF.selectedIndex == -1) return;

    while (sF.selectedIndex != -1) {
        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
        if(action == "remove") {

            var idx = selected_ID_FsArray.indexOf(sF.options[sF.selectedIndex].value); // Find the index
            if(idx!=-1)
                selected_ID_FsArray.splice(idx, 1); // remove item

            //main_ID_F_select.options[sF.selectedIndex] = null;
            //
            for (i = 0; i < main_ID_F_select.length; i++) {
                if (main_ID_F_select.options[i].value == sF.options[sF.selectedIndex].value)
                    main_ID_F_select.options[i] = null;
            }

        } else {
            selected_ID_FsArray.push(sF.options[sF.selectedIndex].value); // add item
            main_ID_F_select.options[main_ID_F_select.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
        }
        sF.options[sF.selectedIndex] = null;

        selected_ID_Fs.value = selected_ID_FsArray.join(",");
    }
}

