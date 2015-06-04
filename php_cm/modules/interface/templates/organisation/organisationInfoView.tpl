<!-- organisationInfoView.tpl -->
{assign var=valueObject value=$interfaceObject->getValueObject()}
<div class="" style="width:{$interfaceObject->getDisplayWidth()};">{$valueObject->infoText|nl2br}</div>
<!-- /organisationInfoView.tpl -->