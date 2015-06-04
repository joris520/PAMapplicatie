<!-- contentForm.tpl -->
<form id="{$formId}" onsubmit="{$formSubmitFunction}('{$formId}');return false;">
    {$hidden_fields}
    <h1>{$formTitle}</h1>
    <div class="wizard-content" style="{if !$fullsize}height:{if $contentPixelHeight}{$contentPixelHeight}{else}300{/if}px;{/if}">
    {$formContent}
    </div>
    {$formContent}
    <input type="submit" id="{'PROCESS_BUTTON'|constant}" value="{if $formSubmitButtonName}{$formSubmitButtonName}{else}{'SAVE'|TXT_BTN}{/if}" class="btn btn_width_80">
    <input type="button" id="{'CANCEL_BUTTON'|constant}" value="{if $formCancelButtonName}{$formCancelButtonName}{else}{'CANCEL'|TXT_BTN}{/if}" class="btn btn_width_80" onclick="{$formCancelFunction};return false;">
</form>
<!-- /contentForm.tpl -->