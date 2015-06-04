
// sdj: hier even geplaatst, omdat er geen mod_libraries.js oid is
function libPrintMsgAlerts()
{
    xajax_moduleEmails_processPrintAlerts(xajax.getFormValues("msgAlertForm"));
    return false;
}



function disableButton(elementID, waitTxt) {
    //xajax.$('btnEmployees').disabled=true;
    //xajax.$('btnEmployees').value="Please wait...";

    var button = document.getElementById(elementID);

    button.disabled = true;
    button.value    = waitTxt;

    return false;
}

function enableButton(elementID, oriTxt) {
    //xajax.$('btnEmployees').disabled=true;
    //xajax.$('btnEmployees').value="Please wait...";

    var button = document.getElementById(elementID);

    button.disabled = false;
    button.value    = oriTxt;

    return false;
}




// define IndexOf if not exists ... (does not exist in MSIE)
if (!Array.indexOf) {
  Array.prototype.indexOf = function (obj, start) {
    for (var i = (start || 0); i < this.length; i++) {
      if (this[i] == obj) {
        return i;
      }
    }
    return -1;
  }
}
function getScrollPosition()
{
	xajax.$('txtScroll').value = xajax.$('scrollDiv').scrollTop;
	return false;
}

function setScroll(position)
{
    if (position > 0) {
        xajax.$('scrollDiv').scrollTop = position;
    }
	return false;
}

function scrollToId(emp_row_id, parent_id) {
    var emp_row = document.getElementById(emp_row_id);
    emp_row.innerHTML = 'scrollToId';
    var scroll_pos = getObjY(emp_row);
    var parent_el = document.getElementById(parent_id);
    var parent_h = parent_el.getPropertyValue(getElementById(parent_id));
    if (scroll_pos > parent_h) {
        scroll_pos = (parent_h/2);
    }
    //alert('scrollToId:' + scroll_pos);
    setScroll(scroll_pos);
}

function storeScrollPos()
{
    document.cookie = 'scrollpos =' + xajax.$('scrollDiv').scrollTop + '; expires';
    return false;
}

function storeMasterScrollPos()
{
    document.cookie = 'scrollpos =' + $('#master_scroll_content').scrollTop + '; expires';
    return false;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
    window.open(theURL,winName,features);
}

/* LOGIN */
function submitLogin()
{
    xajax.$('submitButton').disabled=true;
    xajax_moduleLogin_processLogin(xajax.getFormValues('loginForm'));
    return false;
}

function handleEnter (field, event) {
    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (keyCode == 13) {
        var i;
        for (i = 0; i < field.form.elements.length; i++)
            if (field == field.form.elements[i]) {
                if (document.getElementById('password').value != '') {
                    return submitLogin();
                } else {
                    return false;
                }
                break;
            }
        return false;
    }
    else
        return true;
}

function nextNode(el) {
    elem = el.nextSibling;
    while(elem.innerHTML == null) {
        elem = elem.nextSibling;
    }
    return elem;
}

/* CALENDAR */

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
    cal.sel.value = date; // just update the date in the input field.

    // Roep alleen onchange event aan als deze gedefinieerd is
    if(typeof cal.sel.onchange == "function")
        cal.sel.onchange(); // Forceer een onchange event

    if (cal.dateClicked && (cal.sel.id == "birthdate" || cal.sel.id == "start_date" ||
                            cal.sel.id == "date_start" || cal.sel.id == "end_date" ||
                            cal.sel.id == "from" || cal.sel.id == "to" ||
                            cal.sel.id == "employment_date" || cal.sel.id == "conversation_date" ||
                            cal.sel.id == "default_date" || cal.sel.id == "reference_date")) {
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
        cal.callCloseHandler();
   }
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
    cal.hide();                        // hide the calendar
    //  cal.destroy();
    _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
// LETOP: het element id is die van de datum input, de knop ernaast moet íd + "_cal" hebben
function showCalendar(id, format, showsTime, showsOtherMonths) {
    var el = document.getElementById(id);
    if (_dynarch_popupCalendar != null) {
        // we already have some calendar created
        _dynarch_popupCalendar.hide();                 // so we hide it first.
    } else {
        // first-time call, create the calendar.
        var cal = new Calendar(1, null, selected, closeHandler);
        // uncomment the following line to hide the week numbers
        // cal.weekNumbers = false;
        if (typeof showsTime == "string") {
            cal.showsTime = true;
            cal.time24 = (showsTime == "24");
        }
        if (showsOtherMonths) {
            cal.showsOtherMonths = true;
        }
        _dynarch_popupCalendar = cal;                  // remember it in the global var
        cal.setRange(1900, 2070);        // min/max year allowed.
        cal.create();
    }
    _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
    _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
    _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

    // popup knop opzoeken en hier de calendar tonen
    var showAtObj = document.getElementById(id + "_cal");
    var node_x = getObjX(showAtObj) + 20; // rechts van knop
    var node_y = getObjY(showAtObj);
    _dynarch_popupCalendar.showAt(node_x, node_y);

    // onderstaande code werkt niet in IE bij langere pagina's...
    // the reference element that we pass to showAtElement is the button that
    // triggers the calendar.  In this example we align the calendar bottom-right
    // to the button.
    //_dynarch_popupCalendar.showAtElement(nextNode(el), "Br");        // show the calendar

    return false;
}

function showCalendarInPopup(id, format, showsTime, showsOtherMonths) {
    var el = document.getElementById(id);
    var buttonElementId = id + "_cal";
    var showAtObj = document.getElementById(buttonElementId);

    if (_dynarch_popupCalendar != null) {
        // we already have some calendar created
        _dynarch_popupCalendar.hide();                 // so we hide it first.
    } else {
        // first-time call, create the calendar.
        var cal = new Calendar(1, null, selected, closeHandler);
        // uncomment the following line to hide the week numbers
        // cal.weekNumbers = false;
        if (typeof showsTime == "string") {
            cal.showsTime = true;
            cal.time24 = (showsTime == "24");
        }
        if (showsOtherMonths) {
            cal.showsOtherMonths = true;
        }
        _dynarch_popupCalendar = cal;                  // remember it in the global var
        cal.setRange(1900, 2070);        // min/max year allowed.
        cal.create(null, "fixed");  // de calender aanmaken "onder" de knop"
    }
    _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
    _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
    _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

    // popup knop opzoeken en daarnaast de calendar tonen
    buttonRect=showAtObj.getBoundingClientRect();
    _dynarch_popupCalendar.showAt(buttonRect.left + 20, buttonRect.top); // rechts van knop

    return false;
}

function getObjX(obj) {
    return obj.offsetLeft + (obj.offsetParent ? getObjX(obj.offsetParent) : obj.x ? obj.x : 0);
}
function getObjY(obj) {
    return (obj.offsetParent ? obj.offsetTop + getObjY(obj.offsetParent) : obj.y ? obj.y : 0);
}

//Find X and Y coordinate of HTML control
//
//The main purpose of these two functions given below is to find the absolute positions of a HTML controls measured in it X and Y coordinates. These functions work perfectly in both IE and Firefox.
//
//Below is the code.
//
//Find X position of HTML control


//function findPositionX(obj)
//{
//    var left = 0;
//    if(obj.offsetParent)
//    {
//        while(1)
//        {
//          left += obj.offsetLeft;
//          if(!obj.offsetParent)
//            break;
//          obj = obj.offsetParent;
//        }
//    }
//    else if(obj.x)
//    {
//        left += obj.x;
//    }
//    return left;
//}
//
//
//
////Find Y position of HTML control
//function findPosY(obj)
//{
//    var top = 0;
//
//    if (obj.offsetParent)
//    {
//        while(1)
//        {
//          top += obj.offsetTop;
//          if(!obj.offsetParent)
//            break;
//          obj = obj.offsetParent;
//        }
//    }
//    else if (obj.y)
//    {
//        top += obj.y;
//    }
//    return top;
//  }

/* USERS */

/* hbd: aanzetten blok en bijbehorende link verstoppen */
function doShowBlockHideLink(block_id, link_id)
{
    var show_block = document.getElementById(block_id);
    var hide_link  = document.getElementById(link_id);

    show_block.style.display= 'block';
    hide_link.style.display= 'none';
}


function SelectAllList(CONTROL)
{
    for(var i = 0;i < document.getElementById(CONTROL).length;i++){
        document.getElementById(CONTROL).options[i].selected = true;
    }
}


function DeselectAllList(CONTROL)
{
    for(var i = 0;i < document.getElementById(CONTROL).length;i++){
        document.getElementById(CONTROL).options[i].selected = false;
    }
}


var arrOldValues;
var intOldPos;

function FillListValues(CONTROL)
{
    var arrNewValues;
    var intNewPos;
    var strTemp = GetSelectValues(CONTROL);

    arrNewValues = strTemp.split(",");

    for(var i=0;i<arrNewValues.length-1;i++){
        if(arrNewValues[i]==1){
            intNewPos = i;
        }
    }

    for(var i=0;i<arrOldValues.length-1;i++){
        if(arrOldValues[i]==1 && i != intNewPos){
            CONTROL.options[i].selected= true;
        }
        else if(arrOldValues[i]==0 && i != intNewPos){
            CONTROL.options[i].selected= false;
        }

        if(arrOldValues[intNewPos]== 1){
            CONTROL.options[intNewPos].selected = false;
        }
        else{
            CONTROL.options[intNewPos].selected = true;
        }
    }

    intOldPos = intNewPos;
}


function GetSelectValues(CONTROL)
{
    var strTemp = "";
    for(var i = 0;i < CONTROL.length;i++){
        if(CONTROL.options[i].selected == true){
            strTemp += "1,";
        }
        else{
            strTemp += "0,";
        }
    }

    return strTemp;
}

function GetCurrentListValues(CONTROL)
{
    var strValues = "";

    strValues = GetSelectValues(CONTROL);
    arrOldValues = strValues.split(",")
}



function switchSelectBox(action, sourceSelect, destinationSelect, hiddenSelect) {

    // content of hidden ID_F's that are actually POSTed in the form (and processed afterwards)
    var selected_IDs = document.getElementById(hiddenSelect);
    // array version for processing in this function
    var selected_IDsArray = selected_IDs.value.split(",");

    // sometimes split results in empty first element
    if (selected_IDsArray[0] == "")
        selected_IDsArray.shift();

    // source select
    var sF = document.getElementById(((action == "remove") ? destinationSelect : sourceSelect));
    // destination select
    var dF = document.getElementById(((action == "remove") ? sourceSelect : destinationSelect));

    // wrong item selected or incorrect call of function
    if(sF.length == 0 || sF.selectedIndex == -1) return;

    while (sF.selectedIndex != -1) {
        dF.options[dF.length] = new Option(sF.options[sF.selectedIndex].text, sF.options[sF.selectedIndex].value);
        if(action == "remove") {

            var idx = selected_IDsArray.indexOf(sF.options[sF.selectedIndex].value); // Find the index
            if(idx!=-1)
                selected_IDsArray.splice(idx, 1); // remove item

        } else {
            selected_IDsArray.push(sF.options[sF.selectedIndex].value); // add item
        }
        sF.options[sF.selectedIndex] = null;

        selected_IDs.value = selected_IDsArray.join(",");
    }
}

function get_radio_value(elementName) {
    var elements = document.getElementsByName(elementName);
    for (var i=0; i < elements.length; i++) {
        if (elements[i].checked) {
            var rad_val = elements[i].value;
        }
    }
    return rad_val;
}

function showDateRelative(id, format, relID, relDays) {
    // id: id van het origenele waar de datum aan gerelateerd moet worden
    // format: het formaat waarin de datum wordt getoond en verwerkt
    // relID: het id waarin de datum relatief aan het originele id moet worden getoond
    // relDays: het aantal dagen meer of minder t.o.v. de originele datum

    var elem = document.getElementById(id);
    var elemRel = document.getElementById(relID);

    if (elem.value != "" && elemRel.value != "") {
        var d = Date.parseDate(elem.value, format); // parseDate is een functie die is toegevoegd door Calendar object
        d.setDate(d.getDate() + relDays);

        elemRel.value = d.print(format); // print is een functie die is toegevoegd door Calendar object
    }
}

/**
 * specifieke functie om de customer settings aan te zetten
 */
function showSettingsInDiv(customer_settings_id, link_id)
{
    showDiv(customer_settings_id);
    hideDiv(link_id);
}

function showDiv(show_div_id)
{
    show_div_el = document.getElementById(show_div_id);
    show_div_el.style.display= 'block';
}

function hideDiv(hide_div_id)
{
    hide_div_el = document.getElementById(hide_div_id);
    hide_div_el.style.display= 'none';
}

function showCustomerAdminAccount(customer_account_id)
{
    checkbox_el = document.getElementById(customer_account_id);
    if (checkbox_el.checked == true) {
        document.getElementById(customer_account_id + '_username').style.display='table-row';
        document.getElementById(customer_account_id + '_password1').style.display='table-row';
        document.getElementById(customer_account_id + '_password2').style.display='table-row';
    } else {
        document.getElementById(customer_account_id + '_username').style.display='none';
        document.getElementById(customer_account_id + '_password1').style.display='none';
        document.getElementById(customer_account_id + '_password2').style.display='none';

    }
    inherited(); // zodat de checkbox ook meegaat
}


function changedUserLevel(user_level_select, department_div, no_department_div, min_level, max_level)
{
    select_el = document.getElementById(user_level_select);
    sel_value = select_el.options[select_el.selectedIndex].value;

    if (sel_value >= min_level  && sel_value <= max_level) {
        hideDiv(no_department_div+'1');
        hideDiv(no_department_div+'4');
        hideDiv(no_department_div+'5');
        showDiv(department_div);
    } else {
        hideDiv(no_department_div+'1');
        hideDiv(no_department_div+'4');
        hideDiv(no_department_div+'5');
        hideDiv(department_div);
        if (sel_value >= 0) {
            showDiv(no_department_div+sel_value);
        }
    }
}


function submitPopupSafeForm(form_identifier, form_name)
{
    xajax.$('submitButton').disabled = true;
    hideDialogMessage();
    //alert('submitSafeForm form_identifier:' + form_identifier + '; form_name: ' + form_name);
    xajax_moduleApplication_processPopupSafeForm(form_identifier, xajax.getFormValues(form_name));
    //console.debug(xajax.getFormValues(form_name));
    return false;
}

function submitSafeForm(form_identifier, form_name)
{
    xajax.$('submitButton').disabled = true;
    //alert('submitSafeForm form_identifier:' + form_identifier + '; form_name: ' + form_name);
    xajax_moduleApplication_processSafeForm(form_identifier, xajax.getFormValues(form_name));
    //console.debug(xajax.getFormValues(form_name));
    return false;
}

function submitFilterSafeForm(form_identifier, form_name)
{
    //alert('submitFilterSafeForm form_identifier:' + form_identifier + '; form_name: ' + form_name);
    xajax_moduleApplication_processFilterSafeForm(form_identifier, xajax.getFormValues(form_name));
    return false;
}

function submitActionSafeForm(form_identifier, form_name, button_id)
{
    //alert('submitFilterSafeForm form_identifier:' + form_identifier + '; form_name: ' + form_name);
    xajax_moduleApplication_processActionSafeForm(form_identifier, xajax.getFormValues(form_name), button_id);
    return false;
}

function submitInlineSafeForm(form_identifier, form_name)
{
    //alert('submitInlineSafeForm form_identifier:' + form_identifier + '; form_name: ' + form_name);
    xajax_moduleApplication_processSafeForm(form_identifier, xajax.getFormValues(form_name));
    return false;
}

function selectRadioValue(radioValueId)
{
    $('#'+radioValueId).prop('checked',true);
}