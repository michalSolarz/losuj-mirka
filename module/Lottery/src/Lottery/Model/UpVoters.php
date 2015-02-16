<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 22:34
 */

namespace Lottery\Model;


use Lottery\Model\Parser\Parser;

class UpVoters
{
    private $ajaxBaseLink = "http://www.wykop.pl/ajax2/";
    private $requestType = "upvoters";

    private $upVoters;

    private $lastUpVoter;
    private $lastUpVoterPosition;

    private $activeUpVoters;
    private $inactiveUpVoters;

    function __construct($link, $lastUpVoter)
    {
        $this->setUpVoters($link);
        $this->setUpLastVoter($lastUpVoter);
        $this->splitUpVoters();
    }

    private function setUpVoters($link)
    {
        if (!isset($this->upVoters)) {
            $parser = new Parser($link, $this->ajaxBaseLink, $this->requestType);
            if (($this->upVoters = $parser->parseUpVoters()) == false)
                throw new \Exception("Failed to parse UpVoters");
        }
    }

    private function setUpLastVoter($lastUpVoter)
    {
        if ($lastUpVoterPosition = array_search($lastUpVoter, $this->upVoters)) {
            $this->lastUpVoter = $lastUpVoter;
            $this->lastUpVoterPosition = $lastUpVoterPosition;
        }
    }

    private function splitUpVoters()
    {
        if (isset($this->upVoters) && isset($this->lastUpVoterPosition)) {
            $this->activeUpVoters = $this->upVoters;
            $this->inactiveUpVoters = array_splice($this->activeUpVoters, ($this->lastUpVoterPosition + 1));
        } else
            throw new \Exception("Set UpVoters and LastUpVoter first. Probably invalid last UpVoter nickname.");
    }

    public function getActiveUpVoters()
    {
        if (isset($this->activeUpVoters))
            return $this->activeUpVoters;
        else
            throw new \Exception("Set UpVoters and ActiveUpVoters first.");
    }

    public function getInactiveUpVoters()
    {
        if (isset($this->inactiveUpVoters))
            return $this->inactiveUpVoters;
        else
            throw new \Exception("Set UpVoters and ActiveUpVoters first.");
    }

    public function getUpVoters()
    {
        if (isset($this->upVoters))
            return $this->upVoters;
        else
            throw new \Exception("Set UpVoters first.");
    }

    public function getActiveUpVotersCount()
    {
        return count($this->activeUpVoters);
    }

}