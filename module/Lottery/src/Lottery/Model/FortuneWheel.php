<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 01.01.15
 * Time: 13:07
 */

namespace Lottery\Model;


use Lottery\Model\Random\RandomAPI;
use Lottery\Model\Random\RandomPHP;

class FortuneWheel
{
    private $em;
    private $visible;

    private $baseLink;
    private $lastUpVoter;
    private $numbersAmount;
    private $apiKey = "68035530-0cd1-40dc-a8bf-bf6bd2f0d738";

    private $activeUpVotersCount;
    private $upVoters;
    private $activeUpVoters;
    private $inactiveUpVoters;

    private $resultsSource;

    private $results;
    private $winners;

    private $drawScore;

    function __construct($em, $visible, $baseLink, $lastUpVoter, $numbersAmount, $apiKey = NULL)
    {
        $this->em = $em;
        $this->visible = $visible;
        $this->setBaseLink($baseLink);
        $this->setLastUpVoter($lastUpVoter);
        $this->setNumbersAmount($numbersAmount);
        if ($apiKey != NULL)
            $this->setApiKey($apiKey);
        $this->setResultsSource(1);
        $this->loadUpVoters();
        $this->setResults();
        $this->setWinners();
        $this->drawScore = new DrawScore($this->em, $this->visible, $this->baseLink, $this->lastUpVoter, $this->upVoters, $this->activeUpVoters, $this->inactiveUpVoters, $this->winners);
    }

    private function setBaseLink($baseLink)
    {
        if (!isset($this->baseLink))
            $this->baseLink = $baseLink;
    }

    private function setLastUpVoter($lastUpVoter)
    {
        if (!isset($this->lastUpVoter))
            $this->lastUpVoter = $lastUpVoter;
    }

    private function setNumbersAmount($numbersAmount)
    {
        if (!isset($this->numbersAmount))
            $this->numbersAmount = $numbersAmount;
    }

    private function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function setResultsSource($resultsSource)
    {
        $this->resultsSource = $resultsSource;
    }

    private function setActiveUpVotersCount($activeUpVotersCount)
    {
        if (!isset($this->activeUpVotersCount))
            $this->activeUpVotersCount = $activeUpVotersCount;
    }

    private function setUpVoters($upVoters)
    {
        if (!isset($this->upVoters))
            $this->upVoters = $upVoters;
    }

    private function setActiveUpVoters($activeUpVoters)
    {
        if (!isset($this->activeUpVoters))
            $this->activeUpVoters = $activeUpVoters;
    }

    private function setInactiveUpVoters($inactiveUpVoters)
    {
        if (!isset($this->inactiveUpVoters))
            $this->inactiveUpVoters = $inactiveUpVoters;
    }

    private function setResults()
    {
        if (!isset($this->results))
            $this->results = $this->getRandom();
    }

    private function setWinners()
    {
        $i = 0;
        foreach ($this->results as $item) {
            $this->winners[$i] = $this->activeUpVoters[$item];
            $i++;
        }
    }

    private function loadUpVoters()
    {
        $upVotersLoader = new UpVoters($this->baseLink, $this->lastUpVoter);
        $this->setActiveUpVotersCount($upVotersLoader->getActiveUpVotersCount());
        $this->setUpVoters($upVotersLoader->getUpVoters());
        $this->setActiveUpVoters($upVotersLoader->getActiveUpVoters());
        $this->setInactiveUpVoters($upVotersLoader->getInactiveUpVoters());
    }

    private function getRandom()
    {
        switch ($this->resultsSource) {
            case 0: // Get random from RandomPHP
                $result = $this->getRandomFromPhp();
                break;
            case 1: // Get random from RandomAPI
                $result = $this->getRandomFromApi();
                break;
        }
        return $result;
    }

    private function getRandomFromPhp()
    {
        $random = new RandomPHP($this->activeUpVotersCount, $this->numbersAmount);
        return $random->getResult();
    }

    private function getRandomFromApi()
    {
        $random = new RandomAPI($this->apiKey, $this->activeUpVotersCount, $this->numbersAmount);
        if ($random->apiAvailable())
            return $random->getResult();
        else {
            $this->setResultsSource(0);
            return $this->getRandom();
        }
    }

    public function getWinners()
    {
        return $this->winners;
    }

    public function getDrawScore(){
        return $this->drawScore;
    }
}