<!-- pdpClusterActionsSelector.tpl -->
<table border="0" cellspacing="0" cellpadding="1" width="98%">
    <tr>
        <th class="cluster-title" colspan="100%">{$clusterName}</th>
    </tr>
    <tr>
        <th class="content-title sub-level" width="40%">{'ACTION'|TXT_UCF}</th>
        <th class="content-title" width="25%">{'PROVIDER'|TXT_UCF}</th>
        <th class="content-title" width="25%">{'DURATION'|TXT_UCF}</th>
        <th class="content-title">{'COST'|TXT_UCF}</th>
    </tr>
    {foreach $clusteredPdpActions as $clusteredPdpAction}
    <tr>
        <td class="content-line sub-level" >
        {$clusteredPdpAction.actionSelector}
        </td>
        <td class="content-line" >
        {$clusteredPdpAction.provider}
        </td>
        <td class="content-line" >
        {$clusteredPdpAction.duration}
        </td>
        <td class="content-line" >
        {$clusteredPdpAction.costsHtml}
        </td>
    </tr>
    {/foreach}
</table>
<!-- /pdpClusterActionsSelector.tpl -->