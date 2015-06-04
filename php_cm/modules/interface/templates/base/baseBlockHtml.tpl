<!-- baseBlockHtml.tpl -->
{if $interfaceObject->isSubHeader()}
{assign var=headerClass value=' no-header-block'}
{else}
{assign var=headerClass value=''}
{/if}
{if !$interfaceObject->hasFooter()}
{assign var=noFooterClass value=' no-footer-block'}
{else}
{assign var=noFooterClass value=''}
{/if}
<div class="application-content block-header{$headerClass}" style="width:{$interfaceObject->getDisplayWidth()};">
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
            {$additionalHeaderRow->fetchHtml()}
        {/foreach}
    </table>
</div>
<div class="application-content block-data{$headerClass}{$noFooterClass}" style="width:{$interfaceObject->getDisplayWidth()};">
    {$interfaceObject->getContentHtml()}
</div>
<!-- /baseBlockHtml.tpl -->