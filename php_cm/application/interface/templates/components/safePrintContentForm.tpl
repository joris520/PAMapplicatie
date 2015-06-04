<!-- safePrintContentForm.tpl -->
<form id="{$formId}" name="{$formId}" onsubmit="submitPopupSafeForm('{$safeFormIdentifier}', this.name);return false;">
    {$safeFormToken}
    <h1>{$formTitle}</h1>
    <div id="{'DIALOG_MESSAGE'|constant}" class="dialog-message" style="width:{$contentWidth};"></div>
    {if $buttonTop}
        <div style="width:{$contentWidth}; text-align:{$buttonAlign}">
        <input type="submit" id="{'PRINT_BUTTON'|constant}" value="{'PRINT'|TXT_BTN}" class="btn btn_width_80">
        </div>
    {/if}
    <div class="" style="{if !$fullHeight}height:{if $contentPixelHeight}{$contentPixelHeight}{else}300{/if}px;{/if} width:{$contentWidth};">
        {$formContent}
    </div>
    {if $buttonBottom}
        <div style="width:{$contentWidth}; text-align:{$buttonAlign}">
        <input type="submit" id="{'PRINT_BUTTON'|constant}" value="{'PRINT'|TXT_BTN}" class="btn btn_width_80">
        </div>
    {/if}
</form>
<!-- /safePrintContentForm.tpl -->