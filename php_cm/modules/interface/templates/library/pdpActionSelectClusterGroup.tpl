<!-- pdpActionSelectClusterGroup.tpl -->
        <tr>
            <td colspan="100%">
                <p style="margin:0px; padding-top:15px;"><strong>{$interfaceObject->getClusterName()}</strong></p>
            </td>
        </tr>
        <tr>
            <th class="shaded_title">{'PDP_ACTION'|TXT_UCF}</th>
            <th class="shaded_title">{'PROVIDER'|TXT_UCF}</th>
            <th class="shaded_title">{'DURATION'|TXT_UCF}</th>
            <th class="shaded_title">{'COST'|TXT_UCF}</th>
        </tr>
        {foreach $interfaceObject->getInterfaceObjects() as $pdpActionInterfaceObject}
            {$pdpActionInterfaceObject->fetchHtml()}
        {/foreach}
<!-- /pdpActionSelectClusterGroup.tpl -->