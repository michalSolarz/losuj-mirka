<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 01.01.15
 * Time: 08:59
 */

namespace Lottery\Model\Random;


class RandomPHP
{
    private $downLimit = 0;
    private $upLimit;

    private $count;

    private $result = array();

    function __construct($upLimit, $count)
    {
        $this->setUpLimit($upLimit);
        $this->setCount($count);
        if ($this->upLimit < $this->count)
            throw new \Exception("UpLimit cannot be smaller than count of results.");
        $this->random();
    }

    private function setUpLimit($upLimit)
    {
        if (!isset($this->upLimit))
            $this->upLimit = $upLimit;
    }

    private function setCount($count)
    {
        if (!isset($this->count))
            $this->count = $count;
    }

    private function random()
    {
        for ($i = 0; $i < $this->count; $i++) {
            $randomNumber = $this->randomNumber();
            if (!in_array($randomNumber, $this->result))
                $this->result[$i] = $randomNumber;
            else
                $i--;
        }
    }

    private function randomNumber()
    {
        return mt_rand($this->downLimit, $this->upLimit);
    }

    public function getResult()
    {
        if (isset($this->result))
            return $this->result;
    }

}