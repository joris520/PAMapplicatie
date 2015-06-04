<!-- employeeFilterDetail.tpl -->
{if $interfaceObject->showBossFilter() ||
    $interfaceObject->showDepartmentFilter() ||
    $interfaceObject->showBossFilter() ||
    $interfaceObject->showAssessmentFilter()}
    <table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()};">
    {if $interfaceObject->showBossFilter()}
        {assign var=bossIdValues value=$interfaceObject->getBossFilterIdValues()}
        {if $bossIdValues|count > 1}
        <tr>
            <td>
                <select onchange="{$interfaceObject->submitFunction()}" id="filter_boss" name="filter_boss">
                    {include    file='components/selectIdValuesComponent.tpl'
                                idValues=$bossIdValues
                                currentValue=$interfaceObject->getSelectedBossFilterValue()
                                required=false
                                subject='BOSS'|TXT_LC}
                </select>
            </td>
        </tr>
        {/if}
    {/if}
    {if $interfaceObject->showDepartmentFilter()}
        {assign var=departmentIdValues value=$interfaceObject->getDepartmentFilterIdValues()}
        {if $departmentIdValues|count > 0}
        <tr>
            <td>
                <select onchange="{$interfaceObject->submitFunction()}" id="filter_department" name="filter_department">
                    {include    file='components/selectIdValuesComponent.tpl'
                                idValues=$departmentIdValues
                                currentValue=$interfaceObject->getSelectedDepartmentFilterValue()
                                required=false
                                subject='DEPARTMENT'|TXT_LC}
                </select>
            </td>
        </tr>
        {/if}
    {/if}
    {if $interfaceObject->showFunctionFilter()}
        {assign var=functionIdValues value=$interfaceObject->getFunctionFilterIdValues()}
        {if $functionIdValues|count > 0}
        <tr>
            <td>
                <select onchange="{$interfaceObject->submitFunction()}" id="filter_function" name="filter_function">
                    {include    file='components/selectIdValuesComponent.tpl'
                                idValues=$functionIdValues
                                currentValue=$interfaceObject->getSelectedFunctionFilterValue()
                                required=false
                                subject='FUNCTION'|TXT_LC}
                </select>
            </td>
        </tr>
        {/if}
    {/if}
    {if $interfaceObject->showAssessmentFilter()}
        <tr>
            <td>
                <select onchange="{$interfaceObject->submitFunction()}" id="filter_assessment" name="filter_assessment">
                {include    file         = 'components/selectOptionsComponent.tpl'
                            values       = EmployeeAssessmentFilterValue::values(EmployeeAssessmentFilterValue::MODE_EMPLOYEELIST)
                            currentValue = $interfaceObject->getSelectedAssessmentFilterValue()
                            required     = false
                            subject      = 'STATUS'|TXT_LC
                            converter    = 'EmployeeAssessmentFilterConverter'}
                </select>
            </td>
        </tr>
    {/if}
    {if $interfaceObject->showSortFilter()}
        <tr>
            <td>
                <select onchange="{$interfaceObject->submitFunction()}" id="filter_sort" name="filter_sort">
                {include    file         = 'components/selectOptionsComponent.tpl'
                            values       = EmployeeSortFilterValue::values()
                            currentValue = $interfaceObject->getSelectedSortFilterValue()
                            required     = true
                            converter    = 'EmployeeSortFilterConverter'}
                </select>
            </td>
        </tr>
    {/if}
    </table>
{/if}
<!-- /employeeFilterDetail.tpl -->