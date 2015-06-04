<!-- scoreOperatorComponent.tpl -->
{*scaleType*}
{*inputName*}
    {if $scaleType == ScaleValue::SCALE_Y_N}
        <option value="{OperatorValue::OPERATOR_EQUALS}">{OperatorConverter::display(OperatorValue::OPERATOR_EQUALS)}</option>
    {else}{* ScaleValue::SCALE_1_5 *}
        <option value="{OperatorValue::OPERATOR_GREATER_THAN_OR_EQUALS}">{OperatorConverter::display(OperatorValue::OPERATOR_GREATER_THAN_OR_EQUALS)}</option>
        <option value="{OperatorValue::OPERATOR_EQUALS}">{OperatorConverter::display(OperatorValue::OPERATOR_EQUALS)}</option>
        <option value="{OperatorValue::OPERATOR_LESS_THAN_OR_EQUALS}">{OperatorConverter::display(OperatorValue::OPERATOR_LESS_THAN_OR_EQUALS)}</option>
    {/if}
<!-- scoreOperatorComponent.tpl -->
