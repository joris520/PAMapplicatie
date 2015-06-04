<!-- employeeTabView.tpl -->
<div id="mode_employees">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td class="left_panel" style="width:{$interfaceObject->getDisplayWidth()}; min-width:{$interfaceObject->getDisplayWidth()};">
                {$interfaceObject->getEmployeeListHtml()}
            </td>
            <td class="right_panel" style="padding-left:30px;">
                <div id="tabNav" style="margin-top: 10px;">
                    &nbsp;
                </div>
                <div class="top_nav" id="top_nav" style="margin:0px; padding:6px 0px 0px 0px;">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td id="top_nav_emp" style="vertical-align: middle; text-align: left;">&nbsp;</td>
                            <td id="top_nav_btn" style="vertical-align: middle; text-align: right;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <div id="empPrint">{$interfaceObject->getWelcomeMessage()}</div>
            </td>
        </tr>
    </table>
<div><!-- mode_employees -->
<!-- /employeeTabView.tpl -->