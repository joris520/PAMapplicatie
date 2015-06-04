<!-- nav.tpl -->
<table border="0" cellspacing="0" cellpadding="5" align="right">
    <tr>
        <td><div id="topPrint"></div></td>
        {if $isEmployeeSelected && 'CUSTOMER_OPTION_USE_RATING_DICTIONARY'|constant}
            <td><input type="button" class="btn btn_width_150" id="functbtn" value="{'BASED_ON_JOB_PROFILE'|TXT_BTN}"
                       onclick="xajax_moduleHistory_showEmployeeHistory({$id_e}, '{'RATING_FUNCTION_PROFILE'|constant}'); return false;"/></td>
            <td><input type="button" class="btn btn_width_150" id="compbtn" value="{'BASED_ON_DICTIONARY'|TXT_BTN}"
                       onclick="xajax_moduleHistory_showEmployeeHistory({$id_e}, '{'RATING_DICTIONARY'|constant}'); return false;"/></td>
        {/if}
    </tr>
</table>
<!-- /nav.tpl -->