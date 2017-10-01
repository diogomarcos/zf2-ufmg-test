<?php
/**
 * LoginController
 *
 * @author  Diogo Marcos <contato@diogomarcos.com>
 * @version 1.0
 */

namespace Application\Controller;

use Application\Form\Filter\LoginFilter;
use Application\Form\LoginForm;
use Application\HttpRestJson\WebService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    protected static $session = null;

    /**
     * getSession: Retorna a sessão
     *
     * @return null|Container
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public static function getSession()
    {
        if (self::$session === null) {
            self::$session = new Container('User');
        }
        return self::$session;
    }

    /**
     * indexAction: Realizar o login no sistema
     *
     * @return \Zend\Http\Response|ViewModel
     *
     * @throws \Zend\Http\Exception\InvalidArgumentException
     * @throws \Zend\Session\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\DomainException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function indexAction()
    {
        $this->layout()->setVariable('message', 'Olá Visitante');

        $request = $this->getRequest();

        $view = new ViewModel();
        $login_form = new LoginForm('loginForm');
        $login_form->setInputFilter(new LoginFilter());

        if ($request->isPost()) {
            $form_data = $request->getPost();
            $login_form->setData($form_data);

            if ($login_form->isValid()) {
                $form_data = $login_form->getData();
                $web_service = WebService::authenticate($form_data);

                if (is_array($web_service) && !empty($web_service)) {
                    if (array_key_exists('status', $web_service)) {
                        $this->flashMessenger()->addMessage(array('error' => 'Usuário ou Senha incorretos.'));
                    } elseif (array_key_exists('access_token', $web_service)) {
                        self::getSession()->offsetSet('access_token', $web_service['access_token']);
                        $this->flashMessenger()->addMessage(array('success' => 'Login realizado com sucesso.'));
                    }
                }


                return $this->redirect()->toUrl('/application/login');
            }
        }

        $view->setVariable('loginForm', $login_form);
        return $view;
    }

    /**
     * logoutAction: Sair do sistema
     *
     * @return \Zend\Http\Response
     *
     * @throws \Zend\Session\Exception\InvalidArgumentException
     */
    public function logoutAction()
    {
        self::getSession()->getManager()->destroy();
        return $this->redirect()->toUrl('/application/login');
    }
}
