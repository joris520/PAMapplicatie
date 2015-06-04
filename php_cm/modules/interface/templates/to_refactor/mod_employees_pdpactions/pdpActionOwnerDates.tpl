<!-- pdpActionOwnerDates.tpl -->
<table border="0" cellspacing="0" cellpadding="1">
    <tr>
        <td class="form-label">{'ACTION_OWNER'|TXT_UCF} : </td>
        <td class="form-value">
            <input type="radio" value="{$bossId}" name="actionOwner"{if $bossOwnerSelected} checked="checked"{/if}>{$bossName} <em>({'BOSS'|TXT_LC})</em>, {$bossEmail}
        </td>
    </tr>
    <tr>
        <td class="form-label">&nbsp;</td>
        <td class="form-value">
            <input type="radio" value="{$employeeId}" name="actionOwner"{if $employeeOwnerSelected} checked="checked"{/if}>{$employeeName} <em>({'EMPLOYEE'|TXT_LC})</em>, {$employeeEmail}
        </td>
    </tr>
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'DEADLINE_DATE'|TXT_UCF} : </td>
        <td class="form-value">
            <input name="deadline_date" type="text" id="deadline_date" size="18" maxlength="0" value="{$deadline_date}" readonly="readonly" onChange="showDateRelative('deadline_date', {'JS_DEFAULT_DATE_FORMAT'|constant}, 'notification_date', {'JS_RELATIVE_DAYS_DEADLINE'|constant});">
            {$deadline_calendar_edit}
        </td>
    </tr>
    <tr>
        <td class="form-label">{'NOTIFICATION_DATE'|TXT_UCF} : </td>
        <td class="form-value">
            <input name="notification_date" type="text" id="notification_date" size="18" maxlength="0" value="{$notification_date}" readonly="readonly">
            {$notification_calendar_edit}{$notification_calendar_clear}
        </td>
    </tr>
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
{*
    <tr>
        <td class="form-label">{'NOTIFICATION_EMAILS'|TXT_UCF} : </td>
        <td class="form-value">
            <input type="checkbox" value="{$bossId}" name="actionEmail"{if $bossEmailSelected} checked="checked"{/if}{if $bossHasNoEmail} disabled="disabled"{/if}>{$bossEmail} <em>({$bossName}, {'BOSS'|TXT_LC})</em><br />
            <input type="checkbox" value="{$employeeId}" name="actionEmail"{if $employeeEmailSelected} checked="checked"{/if}{if $employeeHasNoEmail} disabled="disabled"{/if}>{$employeeEmail} <em>({$employeeName}, {'EMPLOYEE'|TXT_LC})</em>
        </td>
    </tr>
*}
    <tr>
        <td class="form-label">{'REASONS_REMARKS'|TXT_UCF} : </td>
        <td class="form-value">
            <textarea name="notes" style="width:600px;height:100px;">{$actionNotes}</textarea>
        </td>
    </tr>
</table>
<!-- /pdpActionOwnerDates.tpl -->
