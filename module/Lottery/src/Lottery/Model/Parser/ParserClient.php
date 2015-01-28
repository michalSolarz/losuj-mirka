<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 30.12.14
 * Time: 00:26
 */

namespace Lottery\Model\Parser;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Client as HttpClient;

class ParserClient extends AbstractActionController
{
    public function getContent($ajaxUrl)
    {
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');

        $response = $this->getResponse();
        //set content-type
        /** @noinspection PhpUndefinedMethodInspection */
        $response->getHeaders()->addHeaderLine('content-type', 'text/html; charset=utf-8');

        $client->setUri($ajaxUrl);
        $result = $client->send();
        //content of the web
        $body = $result->getBody();

        return $body;
    }
}