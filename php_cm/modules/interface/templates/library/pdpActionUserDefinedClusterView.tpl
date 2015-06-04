<!-- pdpActionUserDefinedClusterView.tpl -->
    <tr>
        <td colspan="100%" title="{'ORIGINAL_PDP_ACTION'|TXT_UCF}">
            {if $interfaceObject->isCustomerLibrary()}
                <strong>{$interfaceObject->getPdpActionName()}</strong>
            {else}
                {'NEW_PDP_ACTION'|TXT_UCF}
            {/if}
        </td>
    </tr>
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
            &nbsp;
        </th>
        <th class="shaded_title" style="width:60px;">
            &nbsp;
        </th>
    </tr>

    {if $interfaceObject->hasInterfaceObjects()}
        {foreach $interfaceObject->getInterfaceObjects() as $viewObject}
            {$viewObject->fetchHtml()}
        {/foreach}
    {else}
        {$interfaceObject->displayEmptyMessage()}
    {/if}
    <tr>
        <td colspan="100%">
            &nbsp;
        </td>
    </tr>
<!-- /pdpActionUserDefinedClusterView.tpl -->