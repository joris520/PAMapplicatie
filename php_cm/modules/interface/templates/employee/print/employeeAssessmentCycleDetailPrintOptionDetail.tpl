<!-- employeeAssessmentCycleDetailPrintOptionDetail.tpl -->
{* option *}
{* checkedOptions *}
{include file='components/printOptionRadioComponent.tpl'
            values          = $interfaceObject->getSelectableValues()
            converter       = 'EmployeeModuleDetailPrintOptionConverter'
            currentValue    = $interfaceObject->getCurrentValue()
            inputName       = 'show_cycle_'|cat:$interfaceObject->getPrintOption()
            initialVisible  = $interfaceObject->isInitialVisible()
            indentation     = $interfaceObject->getDetailIndentation()
            option          = $interfaceObject->getPrintOption()}
<!-- /employeeAssessmentCycleDetailPrintOptionDetail.tpl -->