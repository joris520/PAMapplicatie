<!-- pdpActionSummary.tpl -->
<table border="0" cellspacing="0" cellpadding="1">
    <tr>
        <td class="form-label">{'ACTION'|TXT_UCF} : </td>
        <td class="form-value">{$actionName}</td>
    </tr>
    <tr>
        <td class="form-label">{'RELATED_COMPETENCES'|TXT_UCF} : </td>
        <td class="form-value">{$relatedCompetencesHtml}</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'ACTION_OWNER'|TXT_UCF} : </td>
        <td class="form-value">{$actionOwnerName}</td>
    </tr>
    <tr>
        <td class="form-label">{'DEADLINE_DATE'|TXT_UCF} : </td>
        <td class="form-value">{$deadline_date}</td>
    </tr>
    <tr>
        <td class="form-label">{'NOTIFICATION_DATE'|TXT_UCF} : </td>
        <td class="form-value">{$notification_date}</td>
    </tr>
    {if $show_notification_email}
    <tr>
        <td class="form-label">{'NOTIFICATION_EMAILS'|TXT_UCF} : </td>
        <td class="form-value">{$actionOwnerEmail} <em>({'ACTION_OWNER'|TXT_LC})</em></td>
    </tr>
    {/if}
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="form-label">{'REASONS_REMARKS'|TXT_UCF} : </td>
        <td class="form-value">{$actionNotes|nl2br}</td>
    </tr>
</table>
<!-- /pdpActionSummary.tpl -->