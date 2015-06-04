<!-- employeeListDelete.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<p> {$interfaceObject->getConfirmQuestion()}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    <tr>
        <td class="form-label" style="width:150px;">{'EMPLOYEE'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getEmployeeName()}</td>
    </tr>
    <tr>
        <td class="form-label" style="width:150px;">{'DEPARTMENT'|TXT_UCF}</td>
        <td class="form-value">{$valueObject->getDepartmentName()}</td>
    </tr>
    {assign var=bossName value=$valueObject->getBossEmployeeName()}
    {if !empty($bossName)}
    <tr>
        <td class="form-label" style="width:150px;">{'MANAGER'|TXT_UCF}</td>
        <td class="form-value">{$bossName}</td>
    </tr>
    {/if}
</table>
<br/>
<p>{$interfaceObject->getRemoveInfo()}.</p>
<!-- /employeeListDelete.tpl -->