<!-- pdpActionsBatchForm.tpl -->
<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
        <td>
            <form id="pdpActionsBatchForm" name="pdpActionsBatchForm" onsubmit="submitSafeForm('{$formIdentifier}', this.name); return false;">
            {$formToken}
                {$title}
                <!-- add pdp actions -->
                {* <p>{'ACTIONS'|TXT_UCF}</p> *}
                <div class="mod_employees_PDPAction">
                    <table border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td colspan="2">
                            {$pdpActionLibrarySelectorHtml}
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label" style="width:{$labelWidth}px;">
                                {'PDP_ACTION'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                            </td>
                            <td class="form-value">
                                <span id="show_action">-</span>
                                <input type="hidden" id="fill_action" name="fill_action" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                {'PROVIDER'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                            </td>
                            <td class="form-value">
                                <span id="show_provider">-</span>
                                <input type="hidden" id="fill_provider" name="fill_provider" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                {'DURATION'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                            </td>
                            <td class="form-value">
                                <span id="show_duration">-</span>
                                <input type="hidden" id="fill_duration" name="fill_duration" value=""/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form-label">
                                {'COST'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}
                            </td>
                            <td class="form-value">
                                &euro;&nbsp;<span id="show_cost" style="margin:0px;">-</span>
                                <input type="hidden" id="fill_cost" name="fill_cost" value=""/>
                            </td>
                        </tr>
                        </tr>
                            <td colspan="2">&nbsp;</td>
                        <tr>

                        <tr>
                            <!-- select owner -->
                            <td>
                                <strong>{'ACTION_OWNER'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                            </td>
                            <td >
                            {if $limitActionOwner}
                                <input name="action_owner" type="radio" value="{$boss_selected_value}" checked="checked">&nbsp;{'MANAGER'|TXT_UCF}<br/>
                                <input name="action_owner" type="radio" value="{$employee_selected_value}">&nbsp;{'EMPLOYEE'|TXT_UCF}<br/>
                                <br/>
                            {else}
                                {if $owners|@count > 0}
                                <select id="user_id" name="user_id">
                                    <option value="">- {'SELECT'|TXT_LC} -</option>
                                    {foreach $owners as $owner}
                                    <option value="{$owner.user_id}" >{$owner.name}</option>
                                    {/foreach}
                                </select>
                                {else}
                                {'NO_PDP_ACTION_OWNER_RETURN'|TXT_UCF}
                                {/if}
                            {/if}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{'DEADLINE_DATE'|TXT_UCF} {'REQUIRED_FIELD_INDICATOR'|constant}</strong>
                            </td>
                            <td>
                                {$calendarInputDeadlineDateHtml}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{'NOTIFICATION_DATE'|TXT_UCF}</strong></td>
                            <td>
                                {$calendarInputNotificationDateHtml}
                                <a href="" onclick="xajax_moduleEmployees_clearNotificationDate_deprecated();return false;">
                                    <img src="{'ICON_ERASE'|constant}" class="icon-style" border="0" title="Clear notification date"/>
                                </a>
                            </td>
                        </tr>
                        {if !$limitActionOwner}
                        <tr>
                            <td colspan="2">
                                <div id="ne">{$emails_for_notification}</div>
                            </td>
                        </tr>
                        {/if}
                        <tr>
                            <td colspan="2">
                                <br/>
                                <strong>{'REASONS_REMARKS'|TXT_UCF}</strong>
                                <br/>
                                <textarea id="notes" name="notes" style="width:700px;height:130px;"></textarea>
                            </td>
                        </tr>
                    </table>
                    <br/>
                    <p><strong>{'SELECT'|TXT_UCW} {'EMPLOYEES'|TXT_UCW} {'REQUIRED_FIELD_INDICATOR'|constant}</strong></p>
                    {include file='components/select/selectEmployees.tpl'}
                    <br/>
                    <input id="submitButton" type="submit" value="{'PERFORM'|TXT_BTN}" class="btn btn_width_80"/>
                    <input type="button" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="xajax_moduleOrganisation_pdpActionsBatchForm();return false;"/>
                </div>
            </form>
        </td>
    </tr>
</table>
<!-- /pdpActionsBatchForm.tpl -->