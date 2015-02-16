<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.01.15
 * Time: 12:19
 * Class used to save draw score into DB
 */

namespace Lottery\Model;


use Lottery\Entity\DrawScore as DrawScoreEntity;

class DrawScore
{
    private $visible;
    private $hash;
    private $baseLink;
    private $lastUser;
    private $upVoters;
    private $activeUpVoters;
    private $inactiveUpVoters;
    private $winners;

    private $dataTarget;
    private $dbEntity;

    protected $em;

    public function __construct($em, $visible, $baseLink, $lastUser, $upVoters, $activeUpVoters, $inactiveUpVoters, $winners, $dataTarget = 0)
    {
        $this->em = $em;
        if ($dataTarget != 0)
            $this->dataTarget = $dataTarget;
        $this->visible = $visible;
        $this->baseLink = $baseLink;
        $this->lastUser = $lastUser;
        $this->upVoters = $upVoters;
        $this->activeUpVoters = $activeUpVoters;
        $this->inactiveUpVoters = $inactiveUpVoters;
        $this->winners = $winners;
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

    public function getHash()
    {
        return $this->hash;
    }


    private function useDoctrine()
    {
        $em = $this->getEntityManager();
        $entity = $this->doctrineEntity();
        $entity->populate(array(
            'drawTime' => new \DateTime('now'),
            'visible' => $this->visible,
            'hash' => $this->generateHash(),
            'baseLink' => $this->baseLink,
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

    private function generateHash()
    {
        $hashPartOne = md5(time());
        $hashPartTwo = md5(rand(-time(), time()));
        $startOne = rand(0, strlen($hashPartOne) - 10);
        $startTwo = rand(0, strlen($hashPartTwo) - 5);
        $hashPartOne = substr($hashPartOne, $startOne, 10);
        $hashPartTwo = substr($hashPartTwo, $startTwo, 5);
        $result = $hashPartOne . $hashPartTwo;
        $this->hash = $result;
        return $result;
    }

}