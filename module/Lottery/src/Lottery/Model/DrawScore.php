<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.01.15
 * Time: 12:19
 */

namespace Lottery\Model;


use Lottery\Entity\DrawScore as DrawScoreEntity;

class DrawScore
{
    private $drawLink;
    private $lastUser;
    private $upVoters;
    private $activeUpVoters;
    private $inactiveUpVoters;
    private $winners;

    private $dataTarget;
    private $dbEntity;

    protected $em;

    public function __construct($em, $drawLink, $lastUser, $upVoters, $activeUpVoters, $inactiveUpVoters, $winners, $dataTarget = 0)
    {
        $this->em = $em;
        $this->drawLink = $drawLink;
        $this->lastUser = $lastUser;
        $this->upVoters = $upVoters;
        $this->activeUpVoters = $activeUpVoters;
        $this->inactiveUpVoters = $inactiveUpVoters;
        $this->winners = $winners;
        if ($dataTarget != 0)
            $this->dataTarget = $dataTarget;
        $this->proceed();
    }

    private function getEntityManager()
    {
        return $this->em;
    }

    public function proceed()
    {
        switch ($this->dataTarget) {
            case 0: // Save to db using Doctrine 2
                $this->useDoctrine();
                break;
        }
    }


    private function useDoctrine()
    {
        $em = $this->getEntityManager();
        $entity = $this->doctrineEntity();
        $entity->populate(array(
            'drawTime' => new \DateTime('now'),
            'drawLink' => $this->drawLink,
            'lastUser' => $this->lastUser,
            'upVoters' => $this->upVoters,
            'activeUpVoters' => $this->activeUpVoters,
            'inactiveUpVoters' => $this->inactiveUpVoters,
            'winners' => $this->winners,));
        $em->persist($entity);
        $em->flush();
    }

    private function doctrineEntity()
    {
        if (!isset($this->dbEntity))
            $this->dbEntity = new DrawScoreEntity();
        return $this->dbEntity;
    }


}