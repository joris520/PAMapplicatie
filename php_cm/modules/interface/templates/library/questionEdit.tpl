<!-- assessmentQuestionEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td class="form-label" style="width:150px;">
            <label for="sort_order">{'ORDER'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <input id="sort_order" name="sort_order" type="text" maxlength="5" value="{$valueObject->getSortOrder()}" />
        </td>
    </tr>
    <tr>
        <td class="form-label">
            <label for="question">{'ASSESSMENT_QUESTION'|TXT_UCF} {$interfaceObject->getRequiredFieldIndicator()}</label>
        </td>
        <td class="form-value">
            <textarea id="question" name="question" cols="70" rows="3">{$valueObject->getQuestion()}</textarea>
        </td>
    </tr>
</table>
<!-- /assessmentQuestionEdit.tpl -->
