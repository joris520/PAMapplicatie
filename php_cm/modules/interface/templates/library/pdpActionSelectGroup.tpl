<!-- pdpActionSelectGroup.tpl -->
<div style="width:{$interfaceObject->getDisplayWidth(ApplicationInterfaceBuilder::DIALOG_WIDTH_CORRECTION)}; height:{$interfaceObject->getContentHeight()}; overflow:auto;">
    {if $interfaceObject->getInterfaceObjects()|count > 0}
    <table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
        {foreach $interfaceObject->getInterfaceObjects() as $clusterInterfaceObject}
            {$clusterInterfaceObject->fetchHtml()}
        {/foreach}
    </table>
    {else}
        <br/>
        {$interfaceObject->displayEmptyMessage()}
    {/if}
</div>
<!-- /pdpActionSelectGroup.tpl -->