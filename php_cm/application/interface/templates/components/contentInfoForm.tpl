<!-- contentInfoForm.tpl -->
    <h1>{$formTitle}</h1>
    <div class="wizard-content" style="{if !$fullsize}height:{if $contentPixelHeight}{$contentPixelHeight}{else}300{/if}px;{/if} width:{$contentWidth};">
    {$formContent}
    </div>
    <input type="button" id="{'CANCEL_BUTTON'|constant}" value="{if $formCloseButtonName}{$formCloseButtonName}{else}{'CANCEL'|TXT_BTN}{/if}" class="btn btn_width_80" onclick="{if $formCancelFunction}{$formCancelFunction}{else}closeFormDialog(){/if};return false;">
<!-- /contentInfoForm.tpl -->