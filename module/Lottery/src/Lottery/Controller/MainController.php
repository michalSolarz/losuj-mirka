<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 15:18
 */

namespace Lottery\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Lottery\Model\UpVoters;

class MainController extends AbstractActionController
{
    public function indexAction()
    {
        $upVoters = new UpVoters("http://www.wykop.pl/wpis/10749394/czy-warto-pamietac-prawdziwe-fakty-czy-pozwolic-na/", "Riposte");
        var_dump($upVoters->getActiveUpVoters());
    }
}