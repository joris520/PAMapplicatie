<!-- wizardForm.tpl -->
<form id="{$formId}" action="javascript:void(null);" onsubmit="{$formSubmitFunction}('{$formId}');">
    {$hidden_fields}
    <h1>{$formTitle}</h1>
    {$formContent}
    <input type="button" id="{'BACK_BUTTON'|constant}" value="<< {'BACK'|TXT_BTN}" class="btn btn_width_80" onclick="{$formBackFunction}('{$formId}');return false;">
    <input type="submit" id="{'PROCESS_BUTTON'|constant}" value="{if $formSubmitButtonName}{$formSubmitButtonName}{else}{'SAVE'|TXT_BTN} >>{/if}" class="btn btn_width_80">
    <input type="button" id="{'CANCEL_BUTTON'|constant}" value="{'CANCEL'|TXT_BTN}" class="btn btn_width_80" onclick="{$formCancelFunction};return false;">
</form>
<!-- /wizardForm.tpl -->