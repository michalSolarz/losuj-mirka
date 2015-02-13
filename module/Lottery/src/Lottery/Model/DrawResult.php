<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 28.01.15
 * Time: 14:48
 * Class used to retrieve draw score from DB
 */

namespace Lottery\Model;


class DrawResult
{
    protected $em;
    private $dataTarget;

    private $doctrineEntity;

    private $hash;
    private $drawTime;
    private $baseLink;
    private $lastUser;
    private $upVoters;
    private $activeUpVoters;
    private $inactiveUpVoters;
    private $winners;

    public function __construct($em, $hash = NULL, $dataTarget = 0)
    {
        $this->em = $em;
        if ($dataTarget != 0)
            $this->dataTarget = $dataTarget;
        $this->hash = $hash;

    }

    private function getEntityManager()
    {
        return $this->em;
    }

    public function proceed()
    {
        switch ($this->dataTarget) {
            case 0: // Retrieve from DB using Doctrine 2
                $this->useDoctrine();
                break;
        }
        $this->setResult();
    }

    private function useDoctrine()
    {
        $em = $this->getEntityManager();
        $this->doctrineEntity = $em->getRepository('Lottery\Entity\DrawScore')->findOneBy(
            array('hash' => $this->hash));
        if ($this->doctrineEntity === NULL) {
            throw new \Exception('Invalid hash. No such hash in DB.');
        }
    }

    private function setResult()
    {
        switch ($this->dataTarget) {
            case 0: // Prepare Doctrine 2 data
                $source = $this->doctrineEntity;
                $this->drawTime = $source->getDrawTime();
                $this->baseLink = $source->getBaseLink();
                $this->lastUser = $source->getLastUser();
                $this->upVoters = $source->getUpVoters();
                $this->activeUpVoters = $source->getActiveUpVoters();
                $this->inactiveUpVoters = $source->getInactiveUpVoters();
                $this->winners = $source->getWinners();
                break;
        }
    }

    public function getJson()
    {
        return json_encode(array('hash' => $this->hash,
            'drawTime' => $this->drawTime,
            'baseLink' => $this->baseLink,
            'lastUser' => $this->lastUser,
            'upVoters' => $this->upVoters,
            'activeUpVoters' => $this->activeUpVoters,
            'inactiveUpVoters' => $this->inactiveUpVoters,
            'winners' => $this->winners));
    }

    public function properHash()
    {
        $em = $this->getEntityManager();
        $exist = $em->getRepository('Lottery\Entity\DrawScore')->findOneBy(
            array('hash' => $this->hash));
        if ($exist === NULL) {
            return false;
        }
        return true;
    }

    public function getPagedResults($page, $limit)
    {
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        switch ($this->dataTarget) {
            case 0:
                $em = $this->getEntityManager();
                $pagedResults = $em->getRepository('Lottery\Entity\DrawScore')->getPagedResults($offset, $limit);
        }


        return $pagedResults;
    }

    public function getResultsForAjax($page, $limit, $url)
    {
        if ($page - 1 <= 0)
            $previousPage = NULL;
        else
            $previousPage = $this->getParams($this->getPagedResults($page - 1, $limit), $url);

        $currentPage = $this->getParams($this->getPagedResults($page, $limit), $url);

        $nextPage = $this->getParams($this->getPagedResults($page + 1, $limit), $url);
        if ($nextPage == NULL)
            $nextPage = NULL;

        return array('result' => $currentPage,
            'page' => $page,
            'firstPage' => false,
            'lastPage' => false,);
    }

    private function getParams($input, $url)
    {
        $result = '';
        $i = 0;

        foreach ($input as $item) {
            $result .= $this->generateElement('td', $this->generateUrl($url . 'main/showResult/' . $item->getHash(), $url . 'main/showResult/' . $item->getHash()));
            $result .= $this->generateElement('td', $item->getDrawTime()->format('Y-m-d H:i:s'));
            $result = $this->generateElement('tr', $result);

            $i++;
        }


        return $result;
    }

    private function generateElement($element, $content, $class = NULL, $id = NULL, $name = NULL)
    {
        $result = '<' . $element;
        if ($class != NULL)
            $result .= ' class="' . $class . '"';
        if ($id != NULL)
            $result .= 'id="' . $id . '"';
        if ($name != NULL)
            $result .= 'name="' . $name . '"';
        $result .= '>';
        $result .= $content;
        $result .= '</' . $element . '>';
        return $result;
    }

    private function generateUrl($url, $value, $class = NULL, $id = NULL, $name = NULL){
        $result = '<a';
        if ($class != NULL)
            $result .= ' class="' . $class . '"';
        if ($id != NULL)
            $result .= 'id="' . $id . '"';
        if ($name != NULL)
            $result .= 'name="' . $name . '"';
        $result .= ' href="'.$url.'">'.$value.'</a>';
        return $result;
    }
}