<!-- assessmentProcessActionView.tpl -->
<p>{'ACTIONS'|TXT_UCF}</p>
<table border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    <tr>
        <td>
            <div id="{$interfaceObject->getReplaceHtmlId()}">
                {$interfaceObject->getActionHtml()}
            </div>
        </td>
    </tr>
</table>
<hr />
<!-- /assessmentProcessActionView.tpl -->