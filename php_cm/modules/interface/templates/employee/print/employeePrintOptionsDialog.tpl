<!-- employeePrintOptionsDialog.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<table id="print_options" border="0" cellspacing="0" cellpadding="2" style="width:{$interfaceObject->getDisplayWidth()}">
    {include    file                    = 'components/printOptionComponent.tpl'
                inputName               = 'print_option'
                options                 = $valueObject->getPrintOptions()
                checkedOptions          = $interfaceObject->getCheckedPrintOptions()
                converter               = 'EmployeePrintOptionConverter'}
</table>
<!-- /employeePrintOptionsDialog.tpl -->