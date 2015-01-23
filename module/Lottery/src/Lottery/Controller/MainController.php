<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 15:18
 */

namespace Lottery\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
        if($this->getRequest()->isPost()){
            $validator = new DrawFormValidator();
            $form->setInputFilter($validator->getInputFilter());
            $form->setData($this->params()->fromPost());
            if($form->isValid()){
                $data = $form->getData();
                $fortuneWheel = new FortuneWheel($this->getEntityManager(), $data['baseLink'], $data['lastUpVoter'], $data['numbersAmount']);
//                $fortuneWheel->getWinners();
            }
        }

        return new ViewModel(array('form' => $form,));
    }

}