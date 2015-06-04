<!-- employeeAttachment_form.tpl -->
<h1>{$formTitle}</h1>
<table class="form-layout" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td class="form-label">{'CLUSTER'|TXT_UCF} :</td>
        <td class="form-value">{$cluster_selection_html}</td>
    </tr>
    <tr>
        <td class="form-label">{'ATTACHMENT_ACCESS_RIGHTS'|TXT_UCF} :</td>
        <td class="form-value">{$authorisation_selection_html}</td>
    </tr>
    <tr>
        <td class="form-label">{'DESCRIPTION'|TXT_UCF} :</td>
        <td class="form-value"><textarea name="description" cols="35" rows="3" id="description">{$document_info.document_description}</textarea></td>
    </tr>
    <tr>
        <td class="form-label">{'REMARKS'|TXT_UCF} :</td>
        <td class="form-value"><textarea name="remarks" cols="35" rows="3" id="remarks">{$document_info.notes}</textarea></td>
    </tr>
</table>
<!-- /employeeAttachment_form.tpl -->