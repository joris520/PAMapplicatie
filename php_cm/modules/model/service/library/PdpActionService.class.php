<?php

/**
 * Description of PdpActionService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/library/PdpActionQueries.class.php');
require_once('modules/model/valueobjects/library/PdpActionValueObject.class.php');
//require_once('modules/model/valueobjects/library/PdpActionClusterValueObject.class.php');
//require_once('modules/model/valueobjects/library/PdpActionClusterCollection.class.php');
//require_once('modules/model/valueobjects/library/PdpActionClusterGroupCollection.class.php');

class PdpActionService
{
    static function getValueObjects()
    {
        $valueObjects = array();

        $query = PdpActionQueries::getPdpActions();
        while ($pdpActionData = mysql_fetch_assoc($query)) {
            $valueObject = PdpActionValueObject::createWithData($pdpActionData);
            $clusterName = $valueObject->getClusterName();
            $valueObjects[$clusterName][] = $valueObject;
        }
        mysql_free_result($query);

        //ksort($valueObjects);

        return $valueObjects;
    }

    /**
     * voor code completion:
     * @return PdpActionValueObject
     */
    static function getValueObject($pdpActionId)
    {
        $query = PdpActionQueries::getPdpAction($pdpActionId);
        $pdpActionData = mysql_fetch_assoc($query);

        $valueObject = PdpActionValueObject::createWithData($pdpActionData);
        mysql_free_result($query);

        return $valueObject;
    }

    static function getPdpActionIdWithName($actionName)
    {
        $query = PdpActionQueries::findPdpActionWithName($actionName);
        $pdpActionData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $pdpActionData[PdpActionQueries::ID_FIELD];
    }

    static function validate(PdpActionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $clusterId      = $valueObject->getClusterId();
        $pdpActionId    = $valueObject->getId();
        $actionName     = $valueObject->getActionName();
        $provider       = $valueObject->getProvider();
        $duration       = $valueObject->getDuration();
        $cost           = $valueObject->getCost();

        if (empty($clusterId)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
        }
        if (empty($actionName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_ACTION');
        } else {
            $foundId = self::getPdpActionIdWithName($actionName);
            if (!empty($foundId) && (empty($pdpActionId) || $pdpActionId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('PDP_ACTION_NAME_ALREADY_EXISTS');
            }
        }
        if (empty($provider)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
        }
        if (empty($duration)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_DURATION');
        }
        if (!is_numeric($cost)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_COST');
        }
        return array($hasError, $messages);

    }

    static function addValidated(PdpActionValueObject $valueObject)
    {
        return PdpActionQueries::insertPdpAction(   $valueObject->getClusterId(),
                                                    $valueObject->getActionName(),
                                                    $valueObject->getProvider(),
                                                    $valueObject->getDuration(),
                                                    $valueObject->getCost());
    }

    static function updateValidated(PdpActionValueObject $valueObject)
    {
        return PdpActionQueries::updatePdpAction(   $valueObject->getId(),
                                                    $valueObject->getClusterId(),
                                                    $valueObject->getActionName(),
                                                    $valueObject->getProvider(),
                                                    $valueObject->getDuration(),
                                                    $valueObject->getCost());

    }

    static function isRemovablePdpAction(PdpActionValueObject $valueObject)
    {
        return $valueObject->hasId() && !$valueObject->getUsageCount() > 0;
    }

    static function validateRemove(PdpActionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        if (!self::isRemovablePdpAction($valueObject)) {
            $hasError = true;
            $messages[] = TXT_UCF('YOU_CANNOT_DELETE_THE_PDP_ACTION_WHILE_SOME_OF_THE_EMPLOYEE_IS_CONNECTED_IN_IT');
        }
        return array($hasError, $messages);
    }

    static function remove(PdpActionValueObject $valueObject)
    {
        if (self::isRemovablePdpAction($valueObject)) {
            PdpActionQueries::deletePdpAction($valueObject->getId());
        }
    }

}

?>
