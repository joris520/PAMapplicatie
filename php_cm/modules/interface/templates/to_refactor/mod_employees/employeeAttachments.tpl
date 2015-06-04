<!-- employeeAttachments.tpl -->
<table border="0" cellspacing="0" cellpadding="2" width="100%">
{foreach $clusterAttachments as $clusterAttachment}
    <tr>
        <th colspan="100%" class="cluster-title">{$clusterAttachment.clusterName}</th>
    </tr>
    <tr>
        <th width="20%" class="content-title" style="padding-left: 10px;">{'FILENAME'|TXT_UCF}</th>
        <th width="20%" class="content-title">{'DESCRIPTION'|TXT_UCF}</th>
        <th width="20%" class="content-title">{'ATTACHMENT_ACCESS_RIGHTS'|TXT_UCF}</th>
        <th width="25%" class="content-title">{'REMARKS'|TXT_UCF}</th>
        <th width="10%" class="content-title">&nbsp;</th>
    </tr>
    {foreach $clusterAttachment.attachments as $attachment}
    <tr id="cluster_row_{$attachment.ID_EDOC}"  onmouseover="activateThisRow(this);" onmouseout="deactivateThisRow(this);">
        <td class="content-line" style="padding-left: 10px;">{$attachment.documentLink}</td>
        <td class="content-line">{$attachment.document_description|nl2br}&nbsp;</td>
        <td class="content-line">{$attachment.accessListDisplay}&nbsp;</td>
        <td class="content-line">{$attachment.notes|nl2br}&nbsp;</td>
        <td class="content-line action-buttons activeRow">{$attachment.actionButtons}</td>
    </tr>
    {/foreach}
{/foreach}
    <tr>
        <td colspan="100%"><br><div id="logs" align="right">{$lastModifiedLog}</div></td>
    </tr>
</table>
<!-- /employeeAttachments.tpl -->