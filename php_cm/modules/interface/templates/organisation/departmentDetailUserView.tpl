<!-- departmentDetailUserView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<tr>
    <td class="bottom_line{if !$valueObject->isActive} inactive{/if}">
        {$valueObject->name}
    </td>
    <td class="bottom_line{if !$valueObject->isActive} inactive{/if}">
        {$valueObject->login}
    </td>
</tr>
<!-- /departmentDetailUserView -->