<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 15:37
 */

namespace Lottery\Model;

use Zend\Di\Exception\MissingPropertyException;
use /** @noinspection PhpDeprecationInspection */
    Zend\Dom\Query;

class Parser
{
    private $baseLink;
    private $baseAjaxLink;

    private $registryType;
    private $registryId;

    private $hash;
    private $ajaxLink;

    function __construct($baseLink, $baseAjaxLink, $target)
    {
        $this->setBaseLink($baseLink);
        $this->setBaseAjaxLink($baseAjaxLink);
        $this->setRegistryProperties();
        if ($this->setHash())
            $this->setAjaxLink($target);
        else
            throw new \Exception("Failed to parse hash from site.");
    }

    private function setBaseLink($baseLink)
    {
        if (!isset($this->baseLink))
            $this->baseLink = $baseLink;
    }

    public function setRegistryProperties()
    {
        $data = explode('/', $this->baseLink);

        if (!isset($this->registryType))
            $this->registryType = $data[3];

        if (!isset($this->registryId))
            $this->registryId = $data[4];
    }

    private function setBaseAjaxLink($baseAjaxLink)
    {
        if (!isset($this->baseAjaxLink))
            $this->baseAjaxLink = $baseAjaxLink;
    }

    private function setHash()
    {

        $response = false;
        $domd = new \DOMDocument();
        libxml_use_internal_errors(true);

        if (!$this->baseLink)
            throw new MissingPropertyException("baseLink property cannot be NULL");

        $domd->loadHTML(file_get_contents($this->baseLink));

        libxml_use_internal_errors(false);

        $tempMatch = array();
        $match = array();

        $items = $domd->getElementsByTagName('script');
        foreach ($items as $item) {

            $i = $domd->saveHTML($item);

            if (preg_match('/hash (.*)/', $i, $tempMatch)) {
                preg_match('/"(.*)"/', $tempMatch[1], $match);
                if (!isset($this->hash))
                    $this->hash = $match [1];
            }

        }

        if (isset($this->hash))
            $response = True;

        return $response;
    }

    private function setAjaxLink($target)
    {
        if (!isset($this->ajaxLink))
            $this->ajaxLink = $this->baseAjaxLink . $this->registryType . '/' . $target . '/' . $this->registryId . '//' . 'hash/' . $this->hash;
    }

    public function parseUpVoters()
    {
        $parserClient = new ParserClient();
        $data = $parserClient->getContent($this->ajaxLink);
        $i = 0;
        $body = str_replace('\\', '', $data);

        $dom = new Query($body);
        $upVoter = $dom->execute('a');

        $content = array();
        /** @noinspection PhpForeachArrayIsUsedAsValueInspection */
        foreach ($upVoter as $upVoter) {
            if ($upVoter->textContent != NULL)
                $content[$i] = $upVoter->textContent;
            $i++;
        }
        if ($content == NULL)
            return false;
        return $content;
    }

    public function getAjaxUrl()
    {
        return $this->ajaxLink;
    }
}