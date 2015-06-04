<!-- assessmentProcessActionCloseInvitationsConfirm.tpl -->
<p>
    Weet u zeker dat u het invullen van de evaluaties{$interfaceObject->getBossLabel()} af wil ronden?
</p>
{if $interfaceObject->getSelfAssessmentsNotCompletedCount() > 0}
<p>
    Nog niet alle medewerkers ({$interfaceObject->getSelfAssessmentsNotCompletedCount()}) hebben de zelfevaluatie ingevuld.<br />
    Als u de invulperiode voor de medewerkers afsluit, kunnen de medewerkers die nog niet hebben ingevuld dat ook niet meer doen.
</p>
{/if}
<p>
    {if $interfaceObject->getAssessmentsNotCompletedCount() > 0}
    Nog niet alle evaluaties ({$interfaceObject->getAssessmentsNotCompletedCount()}) zijn door {$interfaceObject->getYouLabel()} ingevuld.<br />
    {/if}
    {ucfirst($interfaceObject->getYouLabel())} kunt zelf nog wel invullen en wijzigingen.
</p>
<p>Het systeem zal aan de hand van de door {$interfaceObject->getYouLabel()} en de medewerker ingevulde scores een voorstel doen voor te voeren functioneringsgesprekken.</p>
<!-- /assessmentProcessActionCloseInvitationsConfirm.tpl -->