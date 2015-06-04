<?php

/**
 * Description of EmployeeCompetenceClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/employee/competence/EmployeeCompetenceScoreView.class.php');

class EmployeeCompetenceClusterGroup extends BaseGroupInterfaceObject
{

    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceClusterGroup.tpl';

    // display data
    private $categoryId;
    private $categoryName;
    private $clusterId;
    private $clusterName;

    // acties
    private $editLink;

    // instellingen
    private $clusterHasMainCompetence;
    private $hiliteCluster;
    private $hasIncompleteScores;

    static function create( $displayWidth,
                            $categoryId,
                            $categoryName,
                            $clusterId,
                            $clusterName)
    {
        return new EmployeeCompetenceClusterGroup( $displayWidth,
                                                        $categoryId,
                                                        $categoryName,
                                                        $clusterId,
                                                        $clusterName);
    }

    protected function __construct( $displayWidth,
                                    $categoryId,
                                    $categoryName,
                                    $clusterId,
                                    $clusterName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->categoryId       = $categoryId;
        $this->categoryName     = $categoryName;
        $this->clusterId        = $clusterId;
        $this->clusterName      = $clusterName;
    }

    function getCategoryId()
    {
        return $this->categoryId;
    }

    function getCategoryName()
    {
        return $this->categoryName;
    }

    function getClusterId()
    {
        return $this->clusterId;
    }

    function getClusterName()
    {
        return $this->clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeCompetenceScoreView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $periodIconView
    function setPeriodIconViews(AssessmentIconView $currentPeriodIconView,
                                AssessmentIconView $previousPeriodIconView)
    {
        $this->currentPeriodIconView = $currentPeriodIconView;
        $this->previousPeriodIconView = $previousPeriodIconView;
    }

    function getCurrentPeriodIconView()
    {
        return $this->currentPeriodIconView;
    }

    function getPreviousPeriodIconView()
    {
        return $this->previousPeriodIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $periodEmployeeIconView
    function setPeriodEmployeeIconViews(AssessmentIconView $periodEmployeeIconView,
                                        AssessmentIconView $previousPeriodEmployeeIconView)
    {
        $this->periodEmployeeIconView = $periodEmployeeIconView;
        $this->previousPeriodEmployeeIconView = $previousPeriodEmployeeIconView;
    }

    function getPeriodEmployeeIconView()
    {
        return $this->periodEmployeeIconView;
    }

    function getPreviousPeriodEmployeeIconView()
    {
        return $this->previousPeriodEmployeeIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function markHasIncompleteScores()
    {
        $this->hasIncompleteScores = true;
    }

    function hasIncompleteScores()
    {
        return $this->hasIncompleteScores;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
    }

    function getEditLink()
    {
        return $this->editLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterHasMainCompetence($clusterHasMainCompetence)
    {
        $this->clusterHasMainCompetence = $clusterHasMainCompetence;
    }

    function getClusterHasMainCompetence()
    {
        return $this->clusterHasMainCompetence;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHiliteCluster($hiliteCluster)
    {
        $this->hiliteCluster = $hiliteCluster;
    }

    function hiliteCluster()
    {
        return $this->hiliteCluster;
    }
}

?>
