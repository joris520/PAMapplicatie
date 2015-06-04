<!-- bossAssessmentProcessActionView.tpl -->
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    {assign var=actionMessage value=$interfaceObject->getActionMessage()}
    {if !empty($actionMessage)}
    <tr>
        <td>
            <em>{$actionMessage}</em>
            &nbsp;{$interfaceObject->getUndo()}
        </td>
    </tr>
    {/if}
    <tr>
        <td>
            {$interfaceObject->getAction()}
        </td>
    </tr>
</table>
<!-- /bossAssessmentProcessActionView.tpl -->