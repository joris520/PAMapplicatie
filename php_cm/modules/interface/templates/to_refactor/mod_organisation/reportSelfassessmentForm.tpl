<!-- reportSelfassessmentForm.tpl -->
<div style="margin-left:5px">
    <table width="95%" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <form id="selfassessmentReportForm" name="selfassessmentReportForm" method="POST" action="javascript:void(0);" onsubmit="reportSelfassessmentFormExecute();return false;">
                    <h1>{'SELFASSESSMENT_REPORTS'|TXT_UCF}</h1>
                    {if $functions|@count > 0}
                        {'SELECT_JOB_PROFILE'|TXT_UCF} :
                        <select id="selfassessment_function_id" name="selfassessment_function_id" >
                            <option value="" > - {'SELECT'|TXT_LC} - </option>
                            <option value="-1">{'ALL_JOB_PROFILES'|TXT_UCF}</option>
                            <option value=""></option>
                        {foreach $functions as $function}
                            <option value="{$function.id_f}" >{$function.name}</option>
                        {/foreach}
                        </select>
                        <br />
                        <br />
                        <br />
                        <input type="submit" id="reportsFormBtn" value="{'PERFORM'|TXT_BTN}" class="btn btn_width_80">
                        <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleOrganisation_selfassessmentReportsForm();return false;">
                    {else}
                        {'NO_JOB_PROFILES_RETURN'|TXT_UCF}.
                    {/if}


                </form>
                <div id="download_report"></div>

            </td>
        </tr>
    </table>
</div>
<!-- /reportSelfassessmentForm.tpl -->