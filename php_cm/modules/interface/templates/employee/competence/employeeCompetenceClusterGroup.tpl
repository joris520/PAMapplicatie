<!-- employeeCompetenceClusterGroup.tpl -->
    <tr>
        <td class="shaded_title-new" colspan="100%">
            <table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
                <td>
                    <h3 style="padding:0; margin:0;">
                        {$interfaceObject->getClusterName()}&nbsp;
                        {*{if $showCategory}<em>{CategoryConverter::display($interfaceObject->categoryName)}</em>{/if}*}
                        {if $interfaceObject->hasIncompleteScores()}
                        &nbsp;<span class="warning-text" title="{'TITLE_INCOMPLETE_SCORES'|TXT_UCF}">{'INCOMPLETE_SCORES'|TXT_UCF}&nbsp;</span>
                        {/if}
                    </h3>
                </td>
                <td style="width:200px;" class="actions">
                    {$interfaceObject->getEditLink()}
                </td>
            </table>
        </td>
    </tr>
    {foreach $interfaceObject->getInterfaceObjects() as $scoreInterfaceObject}
        {$scoreInterfaceObject->fetchHtml()}
    {/foreach}{* scoreInterfaceObject *}
    <tr>
        <td colspan="100%">&nbsp;</td>
    </tr>
<!-- /employeeCompetenceClusterGroup.tpl -->