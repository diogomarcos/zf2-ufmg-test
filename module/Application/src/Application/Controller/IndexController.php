<?php
/**
 * IndexController
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Controller;

use Application\HttpRestJson\WebService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * indexAction: Página Inícial
     *
     * @return ViewModel
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Http\Exception\InvalidArgumentException
     */
    public function indexAction()
    {

        $message = 'Olá Visitante';

        $web_service = WebService::account();
        if ($web_service) {
            $message = 'Olá ' . $web_service['name'] . ' (' . $web_service['email'] . ')';
        }
        $this->layout()->setVariable('message', $message);

        return new ViewModel();
    }
}
