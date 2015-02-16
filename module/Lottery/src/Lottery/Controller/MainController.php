<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 15:18
 */

namespace Lottery\Controller;


use Doctrine\Common\Util\Debug;
use Lottery\Model\DrawResult;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Lottery\Model\FortuneWheel;
use Lottery\Form\DrawForm;
use Lottery\FormValidator\DrawForm as DrawFormValidator;

class MainController extends AbstractActionController
{

    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        $form = new DrawForm();
        if ($this->getRequest()->isPost()) {
            $validator = new DrawFormValidator();
            $form->setInputFilter($validator->getInputFilter());
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $fortuneWheel = new FortuneWheel($this->getEntityManager(), $data['visible'], $data['baseLink'], $data['lastUpVoter'], $data['numbersAmount']);
                $hash = $fortuneWheel->getDrawScore()->getHash();
                return $this->redirect()->toRoute('main', array('action' => 'showResult', 'hash' => $hash));
            }
        }

        return new ViewModel(array('form' => $form,));
    }

    public function showResultAction()
    {
        $hash = $this->params()->fromRoute('hash');
        $error = false;
        if (strlen($hash) != 15) {
            throw new \Exception('Invalid hash.');
        }
        $result = new DrawResult($this->getEntityManager(), $hash);
        if (!$result->properHash()) {
            $data = NULL;
            $error = true;
            return new ViewModel(array('data' => $data, 'error' => $error));
        }
        $result->proceed();
        $data = json_decode($result->getJson());

        return new ViewModel(array('data' => $data, 'error' => $error));
    }

    public function archivesAction()
    {
        $page = $this->params()->fromRoute('page', 1);
        $limit = $this->params()->fromRoute('limit', 10);

        if ($page < 1)
            $page = 1;

        $drawResult = new DrawResult($this->getEntityManager());


        $pagedResults = $drawResult->getPagedResults($page, $limit);

        $viewModel = new ViewModel();
        $viewModel->setVariable('pagedResults', $pagedResults);
        $viewModel->setVariable('page', $page);
        $viewModel->setVariable('limit', $limit);

        return $viewModel;
    }

    public function countPagesAction(){
        $limit = $this->params()->fromRoute('limit', 10);

        $drawResult = new DrawResult($this->getEntityManager());

        return new JsonModel(
            $drawResult->countPages($limit));
    }

    public function ajaxArchivesAction()
    {
        $page = $this->params()->fromRoute('page', 1);
        $limit = $this->params()->fromRoute('limit', 10);

        if ($page < 1)
            $page = 1;

        $drawResult = new DrawResult($this->getEntityManager());

        $url = $this->url()->fromRoute('home', array(), array('force_canonical' => true));

        return new JsonModel(
            $drawResult->getResultsForAjax($page, $limit, $url));
    }
}