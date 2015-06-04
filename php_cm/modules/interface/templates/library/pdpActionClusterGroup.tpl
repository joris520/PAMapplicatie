<!-- pdpActionClusterGroup.tpl -->
{if $interfaceObject->hasInterfaceObjects()}
<table border="0" cellspacing="0" cellpadding="4" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <th class="shaded_title" style="width:280px;">
            {'PDP_ACTION'|TXT_UCF}
        </th>
        <th class="shaded_title" style="width:200px;">
            {'PROVIDER'|TXT_UCF}
        </th>
        <th class="shaded_title" style="width:190px;">
            {'DURATION'|TXT_UCF}
        </th>
        <th class="shaded_title" style="text-align:right; width:80px;">
            {'COST'|TXT_UCF} (&euro;)
        </th>
        <th class="shaded_title centered" style="width:80px;">
            {'USAGE'|TXT_UCF}
        </th>
        <th class="shaded_title" style="width:60px;">
            &nbsp;
        </th>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $pdpActionInterfaceObject}
        {$pdpActionInterfaceObject->fetchHtml()}
    {/foreach}
</table>
{else}
    {$interfaceObject->displayEmptyMessage()}
{/if}
<!-- /pdpActionClusterGroup.tpl -->