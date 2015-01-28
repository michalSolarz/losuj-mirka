<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 30.12.14
 * Time: 16:06
 */

namespace Lottery\Model\Random;

use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Http\Response;


class RandomAPI
{
    private $apiKey;

    private $downLimit = 0;
    private $upLimit;
    private $count;

    private $apiUrl = "https://api.random.org/json-rpc/1/invoke";
    private $apiMethod = "POST";

    private $result = array();

    public function __construct($apiKey, $upLimit, $count)
    {
        $this->setApiKey($apiKey);
        $this->setUpLimit($upLimit);
        $this->setCount($count);
    }

    private function setApiKey($apiKey)
    {
        if (!isset($this->apiKey))
            $this->apiKey = $apiKey;
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

    private function generateRequestContent($type)
    {
        switch ($type) {
            case 0: // Check API status
                $result = array(
                    "jsonrpc" => "2.0",
                    "method" => "getUsage",
                    "params" => array(
                        "apiKey" => $this->apiKey,),
                    "id" => $this->generateRequestId(),
                );
                break;
            case 1: // Generate integers
                $result = array(
                    "jsonrpc" => "2.0",
                    "method" => "generateIntegers",
                    "params" => array(
                        "apiKey" => $this->apiKey,
                        "n" => $this->count,
                        "min" => $this->downLimit,
                        "max" => $this->upLimit,
                        "replacement" => false,
                        "base" => 10),
                    "id" => $this->generateRequestId(),
                );
                break;
        }
        return $result;
    }

    private function generateRequestId()
    {
        return time();
    }

    private function makeRequest($type)
    {
        $client = new Client($this->apiUrl, array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl'
        ));
        $client->setEncType(Client::ENC_FORMDATA);

        $request = new Request();
        $request->setUri($this->apiUrl);
        $request->setMethod($this->apiMethod);
        $request->setContent(json_encode($this->generateRequestContent($type)));
        $response = $client->send($request);

        return $response;
    }

    public function parseResponse($type)
    {
        $response = $this->makeRequest($type);
        $content = json_decode($response->getContent());

        switch ($type) {
            case 0:
                $result = $content->result->requestsLeft;
                break;
            case 1:
                $result = $content->result->random->data;
                break;
        }

        return $result;
    }

    private function random()
    {
        $this->result = $this->parseResponse(1);
    }

    public function apiAvailable()
    {
        if ($this->parseResponse(0) > 10)
            return true;
        else
            return false;
    }

    public function getResult()
    {
        $this->random();
        return $this->result;
    }
}