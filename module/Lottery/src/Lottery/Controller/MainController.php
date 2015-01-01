<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 29.12.14
 * Time: 15:18
 */

namespace Lottery\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Lottery\Model\FortuneWheel;

class MainController extends AbstractActionController
{
    public function indexAction()
    {
//        $upVoters = new UpVoters("http://www.wykop.pl/wpis/10749394/czy-warto-pamietac-prawdziwe-fakty-czy-pozwolic-na/", "Riposte");
//        $randomAPI = new RandomAPI("68035530-0cd1-40dc-a8bf-bf6bd2f0d738", 100, 2);
//        echo "<pre>";
//        $response = $randomAPI->getResult();
//        var_dump($response);
//        echo "</pre>";
//        var_dump($randomAPI);
//        $random = new RandomPHP(15, 15);
//        echo "<pre>";
//        var_dump($random->getResult());
//        echo "</pre>";
        $fortuneWheel = new FortuneWheel("http://www.wykop.pl/wpis/10798900/najgorszy-sylwester-w-zyciu-ukroj-chleba-mowili-be/", "dzumper", 1);
//        $fortuneWheel->getWinners();
        echo "<pre>";
        var_dump($fortuneWheel->getWinners());
        echo "</pre>";
    }
}