<!-- employeeResultSelfAssessmentProcessEvaluationSelectView.tpl -->
{assign var=employeeId value=$interfaceObject->getEmployeeId()}
        <!-- states: {$interfaceObject->getStatesInfo()} -->
        <td id="{$interfaceObject->getCheckBoxColorHtmlId($employeeId)}"
            class="dashed_line employee_conversation_unchecked"
            {if $interfaceObject->hasColor()} style="background-color:{$interfaceObject->getColor()};"{/if}
            colspan="2"
            align="center"
            title="{$interfaceObject->getTitle()}">
                <input type="checkbox"
                    id="{$interfaceObject->getCheckBoxHtmlId($employeeId)}"
                        {if $interfaceObject->isEvaluationRequested()}checked{/if}
                        onClick="{$interfaceObject->getCheckBoxOnClick()};"/>
        </td>
<!-- /employeeResultSelfAssessmentProcessEvaluationSelectView.tpl -->