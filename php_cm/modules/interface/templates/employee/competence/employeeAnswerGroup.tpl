<!-- employeeAnswerGroup.tpl -->
{if $interfaceObject->getInterfaceObjects()|count > 0}
    <table  class="content-table employee" style="width:{$interfaceObject->getDisplayWidth()};">
        {foreach $interfaceObject->getInterfaceObjects() as $answerInterfaceObject}
            {$answerInterfaceObject->fetchHtml()}
        {/foreach}{* answerInterfaceObjects *}
        {* symptoombestrijdingshack: *}
        <tr>
            <td></td>
        </tr>
    </table>
{/if}
<!-- /employeeAnswerGroup.tpl -->