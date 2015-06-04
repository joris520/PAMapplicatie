<!-- mod_history.tpl -->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left_panel" style="width:300px; min-width:300px;">
            <div id="search_e" class="search">
                <form name="srcForme" id="srcForme" method="post" action="javascript:void(0);">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td>
                            <strong>{'SEARCH_EMPLOYEE'|TXT_UCF}:</strong>
                            <input type="text" id="s_employee" name="s_employee" size="20" maxlength="10"
                                   onkeyup="xajax_moduleHistory_searchHistoryE(xajax.getFormValues('srcForme')); return false;"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <div id="searchEmployeesResult">
                {include file='to_refactor/mod_history/mod_history_emps.tpl'}
            </div>
        </td>
        <td>
            {include file='to_refactor/mod_history/mod_history_empdata.tpl'}
        </td>
    </tr>
</table>
<!-- /mod_history.tpl -->