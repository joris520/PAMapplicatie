<!-- baseBlock.tpl -->
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

{include file='base/baseBlockHeader.inc.tpl'}

{assign var=dataInterfaceObject value=$interfaceObject->getDataInterfaceObject()}
<div class="application-content block-data{$headerClass}{$noFooterClass}" style="width:{$interfaceObject->getDisplayWidth()};">
    {$dataInterfaceObject->fetchHtml()}
</div>
<!-- /baseBlock.tpl -->