<!-- /safeActionForm.tpl -->
<form id="{$formId}" name="{$formId}" onsubmit="submitActionSafeForm('{$safeFormIdentifier}', this.name);return false;">
    {$safeFormToken}
    {$formContent}
</form>
<!-- /safeActionForm.tpl -->