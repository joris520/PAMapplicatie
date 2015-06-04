<!-- printEmployeesFullPortfolioPage.tpl -->
<table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;">
    <tr>
        <td>
            <br />
            <div id="tabNav"><h1>{$title}</h1></div>

            <form id="{$formID}" onsubmit="{$onSubmitAction}" action="javascript:void(0);" method="POST">
            {*<div class="top_nav">...</div>*}
            <div align="right"><input type="submit" class="btn btn_width_80" value="{'PRINT'|TXT_BTN}" id="btnEmpPrint"> &nbsp;</div>

            {$formdata}

            <br />
            </form>
        </td>
    </tr>
</table>
<!-- /printEmployeesFullPortfolioPage.tpl -->