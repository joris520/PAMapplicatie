<!-- baseTitle.tpl -->
{if $interfaceObject->isSubHeader()}
{assign var=headerClass value=' subheader'}
{else}
{assign var=headerClass value=''}
{/if}

<div class="application-content block-title {$headerClass}" style="width:{$interfaceObject->getDisplayWidth()}; margin-top:20px;">
    <table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
        <tr>
            <td>
                <h2>{$interfaceObject->getHeaderTitle()}</h2>
            </td>
            <td style="width:{$interfaceObject->getActionsWidth()}; text-align:right">
                {$interfaceObject->getActionLinks()}
            </td>
        </tr>
        {foreach $interfaceObject->getAdditionalHeaderRows() as $additionalHeaderRow}
        <tr>
            {$additionalHeaderRow->fetchHtml()}
        </tr>
        {/foreach}
    </table>
</div>
<!-- /baseTitle.tpl -->