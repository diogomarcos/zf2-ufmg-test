<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\HttpRestJson\WebService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {

        $message = 'Olá Visitante';

        $web_service = WebService::account();
        if($web_service) {
            $message = 'Olá ' . $web_service['name'] . ' (' . $web_service['email'] . ')';
        }
        $this->layout()->setVariable('message' , $message);

        return new ViewModel();
    }
}
