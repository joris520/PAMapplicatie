<!-- safeContentForm.tpl -->
<form id="{$formId}" name="{$formId}" onsubmit="submitPopupSafeForm('{$safeFormIdentifier}', this.name);return false;">
    {$safeFormToken}
    {if !empty($formTitle)}<h1>{$formTitle}</h1>{/if}
    <div id="{'DIALOG_MESSAGE'|constant}" class="dialog-message" style="width:{$contentWidth};"></div>
    {if $buttonTop}
    <div style="width:{$contentWidth}; text-align:{$buttonAlign}">
        <input type="submit" id="{$formSubmitButtonId}" value="{if $formSubmitButtonName}{$formSubmitButtonName}{else}{'SAVE'|TXT_BTN}{/if}" class="btn btn_width_80">
        {if $showCancel}
        <input type="button" id="{'CANCEL_BUTTON'|constant}" value="{if $formCancelButtonName}{$formCancelButtonName}{else}{'CANCEL'|TXT_BTN}{/if}" class="btn btn_width_80" onclick="{if $formCancelFunction}{$formCancelFunction}{else}closeFormDialog(){/if};return false;">
        {/if}
    </div>
    {/if}
    <div class="{if !$inBatch}wizard-content{/if}" style="{if !$fullHeight}height:{if $contentPixelHeight}{$contentPixelHeight}{else}300{/if}px;{/if} width:{$contentWidth};">
        {$formContent}
    </div>
    {if $buttonBottom}
    <div style="width:{$contentWidth}; text-align:{$buttonAlign};">
        {if PamApplication::hasModifiedReferenceDate() && $showReferenceDateWarning}
        <span id="referenceDateWarning" class="message warning">
        {/if}
        <input type="submit" id="{$formSubmitButtonId}" value="{if $formSubmitButtonName}{$formSubmitButtonName}{else}{'SAVE'|TXT_BTN}{/if}" class="btn btn_width_80">
        {if $showCancel}
        <input type="button" id="{'CANCEL_BUTTON'|constant}" value="{if $formCancelButtonName}{$formCancelButtonName}{else}{'CANCEL'|TXT_BTN}{/if}" class="btn btn_width_80" onclick="{if $formCancelFunction}{$formCancelFunction}{else}closeFormDialog(){/if};return false;">
        {/if}
        {if PamApplication::hasModifiedReferenceDate() && $showReferenceDateWarning}
            LET OP: de opslagdatum is {DateUtils::convertToDisplayDate(PamApplication::getReferenceDate())}
        </span>
        {/if}
    </div>
    {/if}
</form>
<!-- /safeContentForm.tpl -->