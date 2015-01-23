<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.01.15
 * Time: 12:19
 */

namespace Lottery\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="draw_score")
 * @ORM\Entity
 */
class DrawScore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $drawScoreId;

    /** @ORM\Column(type="datetime") */
    protected $drawTime;

    /** @ORM\Column(type="string", length=100) */
    protected $drawLink;

    /** @ORM\Column(type="string", length=40) */
    protected $lastUser;

    /** @ORM\Column(type="array") */
    protected $upVoters;

    /** @ORM\Column(type="array") */
    protected $activeUpVoters;

    /** @ORM\Column(type="array") */
    protected $inactiveUpVoters;

    /** @ORM\Column(type="array") */
    protected $winners;

    // getters/setters

    /**
     * Get drawScoreId
     *
     * @return integer
     */
    public function getDrawScoreId()
    {
        return $this->drawScoreId;
    }

    /**
     * Set drawTime
     *
     * @param \DateTime $drawTime
     * @return DrawScore
     */
    public function setDrawTime($drawTime)
    {
        $this->drawTime = $drawTime;

        return $this;
    }

    /**
     * Get drawTime
     *
     * @return \DateTime
     */
    public function getDrawTime()
    {
        return $this->drawTime;
    }

    /**
     * Set drawLink
     *
     * @param string $drawLink
     * @return DrawScore
     */
    public function setDrawLink($drawLink)
    {
        $this->drawLink = $drawLink;

        return $this;
    }

    /**
     * Get drawLink
     *
     * @return string
     */
    public function getDrawLink()
    {
        return $this->drawLink;
    }

    /**
     * Set lastUser
     *
     * @param string $lastUser
     * @return DrawScore
     */
    public function setLastUser($lastUser)
    {
        $this->lastUser = $lastUser;

        return $this;
    }

    /**
     * Get lastUser
     *
     * @return string
     */
    public function getLastUser()
    {
        return $this->lastUser;
    }

    /**
     * Set upVoters
     *
     * @param array $upVoters
     * @return DrawScore
     */
    public function setUpVoters($upVoters)
    {
        $this->upVoters = $upVoters;

        return $this;
    }

    /**
     * Get upVoters
     *
     * @return array
     */
    public function getUpVoters()
    {
        return $this->upVoters;
    }

    /**
     * Set activeUpVoters
     *
     * @param array $activeUpVoters
     * @return DrawScore
     */
    public function setActiveUpVoters($activeUpVoters)
    {
        $this->activeUpVoters = $activeUpVoters;

        return $this;
    }

    /**
     * Get activeUpVoters
     *
     * @return array
     */
    public function getActiveUpVoters()
    {
        return $this->activeUpVoters;
    }

    /**
     * Set inactiveUpVoters
     *
     * @param array $inactiveUpVoters
     * @return DrawScore
     */
    public function setInactiveUpVoters($inactiveUpVoters)
    {
        $this->inactiveUpVoters = $inactiveUpVoters;

        return $this;
    }

    /**
     * Get inactiveUpVoters
     *
     * @return array
     */
    public function getInactiveUpVoters()
    {
        return $this->inactiveUpVoters;
    }

    /**
     * Set winners
     *
     * @param array $winners
     * @return DrawScore
     */
    public function setWinners($winners)
    {
        $this->winners = $winners;

        return $this;
    }

    /**
     * Get winners
     *
     * @return array
     */
    public function getWinners()
    {
        return $this->winners;
    }

    public function  populate($data)
    {
        $this->setDrawTime($data['drawTime']);
        $this->setDrawLink($data['drawLink']);
        $this->setLastUser($data['lastUser']);
        $this->setUpVoters($data['upVoters']);
        $this->setActiveUpVoters($data['activeUpVoters']);
        $this->setInactiveUpVoters($data['inactiveUpVoters']);
        $this->setWinners($data['winners']);
    }


}
