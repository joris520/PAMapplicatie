<!-- employeeAnswerEdit.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
{assign var=questionId value=$valueObject->getQuestionId()}
<tr>
    <td class="form-label" colspan="100%"><label for="question_answer_{$questionId}">{$interfaceObject->getDisplayQuestion()|nl2br}</td>
</tr>
<tr>
    <td class="form-value" colspan="100%">
        <textarea name="question_answer_{$questionId}" id="question_answer{$valueObject->getId()}" style="width:98%; height:100px;">{$valueObject->getAnswer()}</textarea>
    </td>
</tr>
<tr>
    <td colspan="100%">&nbsp;</td>
</tr>
<!-- /employeeAnswerEdit.tpl -->